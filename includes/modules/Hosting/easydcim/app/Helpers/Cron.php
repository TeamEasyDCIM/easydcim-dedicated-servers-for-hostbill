<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\GetDeviceBandwidthRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\GetDevicePowerUsageRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order\ListOrdersRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order\OrderData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;

class Cron
{
    /**
     * API v3 caps `per_page` at 100, so orders are looked up in chunks that
     * size rather than the single large filter v2 allowed.
     */
    private const ORDER_CHUNK_SIZE = 100;

    /**
     * Activation condition values, matching the product option.
     */
    private const ACTIVATION_FULL = 'full';

    protected $servers;

    protected $accountsHelper;

    protected $clientsHelper;

    protected $serversHelper;

    protected $mailer;

    public function __construct($servers, $accountsHelper, $mailer, $clientHelper, $serversHelper)
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
                try {
                    $server = $this->getServer($hosting->server_id);
                } catch (Exception $e) {
                    echo $e->getMessage() . PHP_EOL;
                    continue;
                }

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

                if ($bandwidth === null)
                {
                    continue;
                }

                $bandwidthForHosting[$hosting->username] = [
                    'BW_TOTAL'      => $bandwidth->bwTotal,
                    'BW_IN'         => $bandwidth->bwIn,
                    'BW_OUT'        => $bandwidth->bwOut,
                    '95TH_PERC'     => $bandwidth->perc95th,
                    '95TH_PERC_IN'  => $bandwidth->perc95thIn,
                    '95TH_PERC_OUT' => $bandwidth->perc95thOut,
                    'POWER_USAGE'   => $this->getPowerUsageValue(
                        $order['config']['extra_details']['option5'],
                        $startDate,
                        $endDate,
                        $client
                    ),
                ];
            }
        }

        return $bandwidthForHosting;
    }

    /**
     * @return \ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Bandwidth\BandwidthData|null
     */
    private function getBandwidthValues($serverID, $startDate, $endDate, $client)
    {
        try
        {
            $api = ApiClientFactory::fromClient($client);

            $response = $api->admin()->devices()->getBandwidth($serverID, new GetDeviceBandwidthRequest(
                $startDate,
                $endDate,
                'MB'
            ));

            return $response->data;
        }
        catch (Exception $ex)
        {
            echo 'API Error: ' . $ex->getMessage();

            return null;
        }
    }

    /**
     * Average power draw over the billing period, metered like bandwidth.
     *
     * Only collected when the product opts in - EasyDCIM needs a PDU for the
     * device to report anything, so asking for every service would be waste.
     */
    private function getPowerUsageValue($serverID, $startDate, $endDate, $client)
    {
        if (empty($serverID) || $client->getPowerUsageAction() != 'on')
        {
            return 0;
        }

        try
        {
            $api = ApiClientFactory::fromClient($client);

            $response = $api->admin()->devices()->getPowerUsage($serverID, new GetDevicePowerUsageRequest(
                $startDate,
                $endDate
            ));

            return ($response->data === null ? null : $response->data->avgTotalUsage) ?? 0;
        }
        catch (Exception $ex)
        {
            echo 'API Error: ' . $ex->getMessage();

            return 0;
        }
    }

    public function run()
    {
        try {
            $this->checkServices();
        } catch (Exception $ex) {
            echo 'CRON ERROR: ' . $ex->getMessage() . PHP_EOL;
        }
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
                echo $ex->getMessage() . PHP_EOL;
            }
        }
    }

    private function checkFieldsWithOrder($hosting, OrderData $order)
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

    private function synchronizeActiveServices($hosting, OrderData $order)
    {
        if (!empty($order->service === null ? null : $order->service->related_id) && $order->service->status == 'aborted') {
            DB::table('hb_accounts')->where('id','=',$hosting->id)->update([
                'status'=>'Pending'
            ]);
        }
    }

    private function synchronizeServices($hosting, OrderData $order)
    {
        $service = $order->service;

        if (empty($service === null ? null : $service->related_id)) {
            throw new Exception('Device is not assigned.');
        }

        if ($service->status == 'aborted') {
            DB::table('hb_accounts')->where('id','=',$hosting->id)->update([
                'status'=>'Pending'
            ]);

            return;
        }

        if ($service->status != 'activated') {
            throw new Exception('Waiting, service status: ' . $service->status);
        }

        try {
            $server = $this->getServer($hosting->server_id);
        } catch (Exception $ex) {
            echo $ex->getMessage() . PHP_EOL;
            return;
        }

        $orderCfg['config']['extra_details']['option4'] = unserialize($hosting->extra_details)['option4'];
        $params = array_merge($server, $orderCfg);
        $client = new ClientAdapter($params);
        $api    = ApiClientFactory::fromClient($client);

        $device = $api->admin()->devices()->show($service->related_id)->data;

        // "Full" activation waits for the OS install to finish before the
        // service is handed to the client.
        if ($this->getActivationCondition($hosting) === self::ACTIVATION_FULL
            && (string) (($device === null ? null : $device->osInstallation) ?? '') !== '1') {
            throw new Exception('Waiting for the OS installation to finish.');
        }

        $extraDetails = unserialize($hosting->extra_details);
        $extraDetails['option5'] = $service->related_id;

        if (!empty($service->id)) {
            $extraDetails['option9'] = $service->id;
        }

        $extraDetails['option8'] = ($device === null ? null : $device->metadata)['IP Address'] ?? '';

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

    /**
     * The product's service activation condition.
     */
    private function getActivationCondition($hosting): string
    {
        $row = DB::table('hb_products_modules')
            ->join('hb_modules_configuration', 'hb_products_modules.module', '=', 'hb_modules_configuration.id')
            ->where('hb_modules_configuration.module', '=', 'easydcim')
            ->where('hb_products_modules.product_id', '=', $hosting->product_id)
            ->select('hb_products_modules.options')
            ->first();

        if (empty($row)) {
            return '';
        }

        $options = @unserialize($row->options);

        if (!is_array($options)) {
            return '';
        }

        $value = $options['serviceActivationCondition'] ?? '';

        return (string) (is_array($value) ? ($value['value'] ?? '') : $value);
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

    /**
     * Look the orders up per HostBill server, in chunks, and key them by ID.
     *
     * @return array<int|string, OrderData>
     */
    private function fetchOrdersBulkByServer(array $orderMap): array
    {
        $orders = [];

        foreach ($orderMap as $serverId => $orderIds) {
            try {
                $server = $this->getServer((int)$serverId);
                $client = new ClientAdapter($server);
                $api    = ApiClientFactory::fromClient($client);
            } catch (Exception $ex) {
                echo $ex->getMessage() . PHP_EOL;
                continue;
            }

            foreach (array_chunk(array_unique($orderIds), self::ORDER_CHUNK_SIZE) as $chunk) {
                try {
                    $result = $api->admin()->orders()->listAll(new ListOrdersRequest(self::ORDER_CHUNK_SIZE, null, null, null, implode(',', $chunk), 'in', 'id'));

                    foreach ($result as $order) {
                        $orders[$order->id] = $order;
                    }
                } catch (Exception $ex) {
                    echo $ex->getMessage() . PHP_EOL;
                    continue;
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
