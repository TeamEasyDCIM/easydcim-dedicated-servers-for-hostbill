<?php

require_once dirname(__DIR__).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\Cron;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\OsTemplatesSync;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\StockControl;

class easydcim_controller extends HBController
{
    var $module;
    protected $cron;
    protected $hostBillApi;
    protected $accounts_helper;
    protected $servers_helper;
    protected $client_helper;
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new Mailer();
        $this->hostBillApi = new ApiWrapper();
        $this->accounts_helper = HBLoader::LoadModel('Accounts');
        $this->servers_helper = HBLoader::LoadModel('Servers');
        $this->client_helper = HBLoader::LoadModel("Clients");
    }

    function call_EveryRun() {
        $servers = $this->servers_helper->findServersBy('module','easydcim');
        $this->cron = new Cron($servers,$this->accounts_helper,$this->mailer,$this->client_helper,$this->servers_helper);
        $this->cron->run();
    }
    function call_Hourly(){
        $servers = $this->servers_helper->findServersBy('module','easydcim');
        $this->cron = new Cron($servers,$this->accounts_helper,$this->mailer,$this->client_helper,$this->servers_helper);
        $bandwidth = $this->cron->getBandwidth();
        foreach($bandwidth as $username => $usage) {
            $account_id = $this->accounts_helper->findAccountIdBy('username', $username);
            if ($account_id) {
                $this->hostBillApi->meteredAddUsage(array(
                    'account_id' => $account_id,
                    'variable' => 'bandwidthIn',
                    'qty' => $usage['BW_IN']
                ));
                $this->hostBillApi->meteredAddUsage(array(
                    'account_id' => $account_id,
                    'variable' => 'bandwidthOut',
                    'qty' => $usage['BW_OUT']
                ));
                $this->hostBillApi->meteredAddUsage(array(
                    'account_id' => $account_id,
                    'variable' => 'bandwidthTotal',
                    'qty' => $usage['BW_TOTAL']
                ));
                $this->hostBillApi->meteredAddUsage(array(
                    'account_id' => $account_id,
                    'variable' => 'percentileIn',
                    'qty' => $usage['95TH_PERC_IN']
                ));
                $this->hostBillApi->meteredAddUsage(array(
                    'account_id' => $account_id,
                    'variable' => 'percentileOut',
                    'qty' => $usage['95TH_PERC_OUT']
                ));
                $this->hostBillApi->meteredAddUsage(array(
                    'account_id' => $account_id,
                    'variable' => 'percentileTotal',
                    'qty' => $usage['95TH_PERC']
                ));
                $this->hostBillApi->meteredAddUsage(array(
                    'account_id' => $account_id,
                    'variable' => 'powerUsage',
                    'qty' => $usage['POWER_USAGE']
                ));
            }
        }
    }
    function call_Daily(){
        $servers = $this->servers_helper->findServersBy('module','easydcim');

        // Keep product availability in step with what EasyDCIM can provision.
        (new StockControl($servers))->run();

        // Pick up OS templates, disk layouts and extras added in EasyDCIM.
        (new OsTemplatesSync($servers, HBLoader::LoadModel("ConfigFields")))->run();
    }
    function call_Weekly(){

    }
    function call_Monthly(){

    }
}