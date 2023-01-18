<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use Exception;
use Illuminate\Support\Collection;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Database\Database;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices\Bandwidth;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\InvoicingDate;
use Carbon\Carbon;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\Emails;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;

class Cron
{
    protected $db;
    protected $servers;
    protected $accountsHelper;
    protected $clientsHelper;
    protected $serversHelper;
    protected $mailer;

    public function __construct($servers,$accountsHelper,$mailer,$clientHelper,$serversHelper)
    {
        $this->mailer = $mailer;
        $db = new Database();
        $this->db = $db->getConnection();
        $this->servers = $servers;
        $this->accountsHelper = $accountsHelper;
        $this->clientsHelper = $clientHelper;
        $this->serversHelper = $serversHelper;
    }

    public function getBandwidth()
    {
        $bandwidthForHosting = [];
        $hostings = $this->getHostings();
        foreach ($hostings as $key=>$hosting)
        {
            $customFieldsValues = unserialize($hosting->extra_details);
            if ($customFieldsValues['option4'] != '')
            {
                $server = $this->getServer($hosting->server_id);
                $order['config']['extra_details']['option4'] = $customFieldsValues['option4'];
                $order['config']['extra_details']['option5'] = $customFieldsValues['option5'];
                $params = array_merge($server, $order);
                $client = new ClientAdapter($params);
                if ($customFieldsValues['bandwidthUsageFromRegistrationDate']['value'] == "on")
                {
                    $startDate = InvoicingDate::checkAndGetDate($hosting) . " 00:00:01";
                }
                else
                {
                    $startDate = InvoicingDate::getFirstDay() . " 00:00:01";
                }
                $endDate   = Carbon::now()->toDateTimeString();

                $bandwidth   = $this->getBandwidthValues($order['config']['extra_details']['option5'],$startDate,$endDate,$client);
                $bandwidthForHosting[$hosting->username] = [
                    'BW_TOTAL'=>$bandwidth->{'BW_TOTAL'},
                    'BW_IN'=>$bandwidth->{'BW_IN'},
                    'BW_OUT'=>$bandwidth->{'BW_OUT'},
                    '95TH_PERC'=>$bandwidth->{'95TH_PERC'},
                    '95TH_PERC_IN'=>$bandwidth->{'95TH_PERC_IN'},
                    '95TH_PERC_OUT'=>$bandwidth->{'95TH_PERC_OUT'},
                ];
            }
        }
        return $bandwidthForHosting;
    }

    private function getBandwidthValues($serverID, $startDate, $endDate,$client)
    {
        try
        {
            $api    = new EasyDCIM($client);
            $bandwidthModel = new Bandwidth();
            $bandwidthModel->setStartDate($startDate)
                ->setEndDate($endDate)
                ->setUnits('MB');

            return $api->device->bandwidth($bandwidthModel, $serverID);
        }
        catch (\Exception $ex)
        {
            echo print_r('API Error: ' . $ex->getMessage(), true);
        }
    }

    /**
     * Run to check server to synchronize
     */
    public function run()
    {
        $this->checkServices();
    }

    /**
     * Get all Easy DCIM Colocation Products
     * @return Collection|null
     */
    public function getAllEasyProduct()
    {
        return $this->db->table('hb_products')->where('code','=','EasyDCIM')->get();
    }

    /**
     * Get all Hostings with to Easy DCIM Colocation Module
     * @return null|array of objects
     */
    public function getHostings()
    {
        $allHostings = [];
        foreach ($this->getAllEasyProduct() as $product)
        {
            $hostings = $this->db->table('hb_accounts')->where('product_id','=',$product->id)->where('status','=','Active')->get();

            foreach ($hostings as $hosting)
            {
                $allHostings[] = $hosting;
            }
        }


        return $allHostings;
    }

    /**
     * Check and Synchroznize all Active Easy DCIM Colocation
     */
    public function checkServices()
    {

        foreach ($this->getHostings() as $hosting)
        {
            try
            {
                $this->checkFields($hosting);
            }
            catch (Exception $ex)
            {
            }
        }
    }


    /**
     * @return void
     */
    public function checkFields($hosting)
    {
        $customFieldsValues = unserialize($hosting->extra_details);
        $orderID  = $customFieldsValues['option4'];
        $serverID = $customFieldsValues['option5'];
        $lastModuleAction = $customFieldsValues['option6'];

        if (empty($orderID))
        {
            throw new Exception('Order ID is empty!');
        }

        if(in_array($lastModuleAction, ['CreateAccount', 'SuspendAccount', 'UnsuspendAccount', 'TerminateAccount']) && ! empty($serverID)) {
            $this->synchronizeActiveServices($orderID, $hosting, $lastModuleAction);
        }

        if (empty($serverID))
        {
            $this->synchronizeServices($orderID, $hosting);
        }
    }

    /**
     * @param $orderID
     * @param $hosting
     * @param $lastModuleAction
     * @throws Exception
     */
    private function synchronizeActiveServices($orderID, $hosting, $lastModuleAction)
    {
        $account_id = $hosting->id;

        $server = $this->getServer($hosting->server_id);
        $order['config']['extra_details']['option4'] = $orderID;
        $params = array_merge($server, $order);
        $client = new ClientAdapter($params);
        $api    = new EasyDCIM($client);
        $info   = $api->order->getOrder();

        if (!empty($info->service->related_id)) {
            if($info->service->status == 'aborted') {
//                Queue::add('Server', $hosting->id, 'EasyDCIM', $lastModuleAction, 'Service aborted in EasyDCIM');
//                Logs::save('CRON', $info, "Service aborted in EasyDCIM", $hosting->packageid);
            }
        }
    }

    /**
     * @param $orderID
     * @param Hosting $hosting
     * @return void
     */
    private function synchronizeServices($orderID, Hosting $hosting)
    {
        $server = $this->getServer($hosting->server);
        $order['customfields']['OrderID'] = $orderID;
        $params = array_merge($server, $order);
        $this->checkOrder($params, $hosting);
    }

    /**
     * @param $params
     * @param $hosting
     * @return void
     * @throws Exception
     */
    private function checkOrder($params,$hosting)
    {
        $client = new ClientAdapter($params);
        $api    = new EasyDCIM($client);
        $info   = $api->order->getOrder();
        if (!empty($info->service->related_id)) {
            if($info->service->status == 'aborted') {
                $this->db->table('hb_accounts')->where('id','=',$hosting->id)->update([
                    'status'=>'Pending'
                ]);
            } elseif($info->service->status == 'activated') {
                $extraDetails = unserialize($hosting->extra_details);
                $extraDetails['option5'] = $info->service->related_id;
                $device = $api->device->getInformation($info->service->related_id);
                $extraDetails['option8'] = $device->metadata->{'IP Address'};
                $this->db->table('hb_accounts')->where('id','=',$hosting->id)->update([
                    'extra_details'=>serialize($extraDetails),
                    'status'=>'Active'
                ]);
                $account = $this->accountsHelper->getAccount($hosting->id);
                $server = $this->serversHelper->getServerDetails($account["server_id"]);
                $clientData = $this->clientsHelper->getClient($account['client_id']);
                $createTemplateId = $client->getNotificationServerCreate();
                $emailTemplates = new EmailNotifications($this->db);
                $emails = new Emails($this->mailer);
                $emails->sendServerCreateEmail($client,$emailTemplates->getTemplate($createTemplateId),$clientData,$account,$server);
            } else {
                throw new Exception('Waiting, service status: ' . $info->service->status);
            }
        } else {
            throw new Exception('Device is not assigned.');
        }
    }

    /**
     * Get and prepare server information
     *
     * @param integer $serverId
     * @throw exception
     */
    private function getServer(int $serverId)
    {
        foreach ($this->servers as $key=>$value)
        {
            if ($value['id'] == $serverId)
            {
                $serverConfig = [
                    'serversecure' => $value['secure'] == '1' ? 'on': '',
                    'serverip' => $value['ip'],
                    'serverhostname' => $value['host'],
                    'username' => $value['username'],
                    'serverpassword' => $value['password'],
                ];
            }
        }
        if (!is_null($serverConfig)) {
            return $serverConfig;
        }
        throw new Exception('Server not exists! Server ID #' . $serverId);
    }

}