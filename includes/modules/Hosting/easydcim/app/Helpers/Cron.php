<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use Exception;
use Illuminate\Support\Collection;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices\Bandwidth;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders\Filters;
use Carbon\Carbon;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;
use Illuminate\Database\Capsule\Manager as DB;

class Cron
{
    protected $servers;
    protected $accountsHelper;
    protected $clientsHelper;
    protected $serversHelper;
    protected $mailer;

    public function __construct($servers,$accountsHelper,$mailer,$clientHelper,$serversHelper)
    {
        $this->mailer = $mailer;
        $this->servers = $servers;
        $this->accountsHelper = $accountsHelper;
        $this->clientsHelper = $clientHelper;
        $this->serversHelper = $serversHelper;
    }

    public function getBandwidth()
    {
        $bandwidthForHosting = [];
        $hostings = $this->getHostings();

        foreach ($hostings as $hosting)
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

                $endDate = Carbon::now()->toDateTimeString();

                $bandwidth = $this->getBandwidthValues(
                    $order['config']['extra_details']['option5'],
                    $startDate,
                    $endDate,
                    $client
                );

                $bandwidthForHosting[$hosting->username] = [
                    'BW_TOTAL'       => $bandwidth->{'BW_TOTAL'},
                    'BW_IN'          => $bandwidth->{'BW_IN'},
                    'BW_OUT'         => $bandwidth->{'BW_OUT'},
                    '95TH_PERC'      => $bandwidth->{'95TH_PERC'},
                    '95TH_PERC_IN'   => $bandwidth->{'95TH_PERC_IN'},
                    '95TH_PERC_OUT'  => $bandwidth->{'95TH_PERC_OUT'},
                ];
            }
        }

        return $bandwidthForHosting;
    }

    private function getBandwidthValues($serverID, $startDate, $endDate,$client)
    {
        try
        {
            $api = new EasyDCIM($client);
            $bandwidthModel = new Bandwidth();
            $bandwidthModel->setStartDate($startDate)
                ->setEndDate($endDate)
                ->setUnits('MB');

            return $api->device->bandwidth($bandwidthModel, $serverID);
        }
        catch (Exception $ex)
        {
            echo 'API Error: ' . $ex->getMessage();
        }
    }

    public function run()
    {
        $this->checkServices();
    }

    public function getAllEasyProduct()
    {
        return DB::table('hb_modules_configuration')
            ->join('hb_products_modules','hb_products_modules.module','=','hb_modules_configuration.id')
            ->join('hb_products','hb_products_modules.product_id','=','hb_products.id')
            ->where('hb_modules_configuration.module','=','easydcim')
            ->get();
    }

    public function getHostings()
    {
        $allHostings = [];

        foreach ($this->getAllEasyProduct() as $product)
        {
            $hostings = DB::table('hb_accounts')
                ->where('product_id','=',$product->id)
                ->where('status','=','Active')
                ->get();

            foreach ($hostings as $hosting)
            {
                $allHostings[] = $hosting;
            }
        }

        return $allHostings;
    }

    public function checkServices()
    {
        $hostings = $this->getHostings();
        if (empty($hostings)) {
            return;
        }

        $orderMap = $this->extractOrderIdsByServer($hostings);

        if (empty($orderMap)) {
            return;
        }

        $orders = $this->fetchOrdersBulkByServer($orderMap);

        foreach ($hostings as $hosting)
        {
            try
            {
                $extra = unserialize($hosting->extra_details);
                $orderId = $extra['option4'];

                if (!isset($orders[$orderId])) {
                    continue;
                }

                $this->checkFieldsWithOrder($hosting, $orders[$orderId]);
            }
            catch (Exception $ex)
            {
                echo $ex->getMessage();
            }
        }
    }


    private function checkFieldsWithOrder($hosting, $order)
    {
        $customFieldsValues = unserialize($hosting->extra_details);

        $orderID  = $customFieldsValues['option4'];
        $serverID = $customFieldsValues['option5'];
        $lastModuleAction = $customFieldsValues['option6'];

        if (empty($orderID))
        {
            throw new Exception('Order ID is empty!');
        }

        if (in_array($lastModuleAction, ['CreateAccount', 'SuspendAccount', 'UnsuspendAccount', 'TerminateAccount'])
            && !empty($serverID)) {
            $this->synchronizeActiveServices($hosting, $order);
        }

        if (empty($serverID))
        {
            $this->synchronizeServices($hosting, $order);
        }
    }

    private function synchronizeActiveServices($hosting, $order)
    {
        if (!empty($order->service->related_id) && $order->service->status == 'aborted') {
            DB::table('hb_accounts')->where('id','=',$hosting->id)->update([
                'status'=>'Pending'
            ]);
        }
    }

    private function synchronizeServices($hosting, $order)
    {
        if (!empty($order->service->related_id)) {

            if ($order->service->status == 'aborted') {
                DB::table('hb_accounts')->where('id','=',$hosting->id)->update([
                    'status'=>'Pending'
                ]);
            }
            elseif ($order->service->status == 'activated') {

                $extraDetails = unserialize($hosting->extra_details);
                $extraDetails['option5'] = $order->service->related_id;

                $server = $this->getServer($hosting->server_id);
                $orderCfg['config']['extra_details']['option4'] = $extraDetails['option4'];
                $params = array_merge($server, $orderCfg);
                $client = new ClientAdapter($params);
                $api    = new EasyDCIM($client);

                $device = $api->device->getInformation($order->service->related_id);
                $extraDetails['option8'] = $device->metadata->{'IP Address'};

                DB::table('hb_accounts')->where('id','=',$hosting->id)->update([
                    'extra_details'=>serialize($extraDetails),
                    'status'=>'Active'
                ]);

                $account = $this->accountsHelper->getAccount($hosting->id);
                $serverDetails = $this->serversHelper->getServerDetails($account["server_id"]);
                $clientData = $this->clientsHelper->getClient($account['client_id']);

                $createTemplateId = $client->getNotificationServerCreate();
                $emailTemplates = new EmailNotifications();
                $emails = new Emails($this->mailer);
                $emails->sendServerCreateEmail(
                    $client,
                    $emailTemplates->getTemplate($createTemplateId),
                    $clientData,
                    $account,
                    $serverDetails
                );
            }
            else {
                throw new Exception('Waiting, service status: ' . $order->service->status);
            }
        }
        else {
            throw new Exception('Device is not assigned.');
        }
    }

    private function extractOrderIdsByServer(array $hostings): array
    {
        $map = [];

        foreach ($hostings as $hosting) {
            $extra = unserialize($hosting->extra_details);

            if (!empty($extra['option4'])) {
                $map[$hosting->server_id][] = $extra['option4'];
            }
        }

        return $map;
    }

    private function fetchOrdersBulkByServer(array $orderMap): array
    {
        $orders = [];
        $chunkSize = 900;

        foreach ($orderMap as $serverId => $orderIds) {

            $server = $this->getServer($serverId);
            $client = new ClientAdapter($server);
            $api    = new EasyDCIM($client);

            foreach (array_chunk(array_unique($orderIds), $chunkSize) as $chunk) {

                $filters = new Filters();
                $filters->setIds($chunk);

                $result = $api->order->getOrders($filters);

                if ($result) {
                    foreach ($result as $order) {
                        $orders[$order->id] = $order;
                    }
                }
            }
        }

        return $orders;
    }

    private function getServer(int $serverId)
    {
        foreach ($this->servers as $value)
        {
            if ($value['id'] == $serverId)
            {
                return [
                    'serversecure' => $value['secure'] == '1' ? 'on': '',
                    'serverip' => $value['ip'],
                    'serverhostname' => $value['host'],
                    'username' => $value['username'],
                    'serverpassword' => $value['password'],
                ];
            }
        }

        throw new Exception('Server not exists! Server ID #' . $serverId);
    }
}