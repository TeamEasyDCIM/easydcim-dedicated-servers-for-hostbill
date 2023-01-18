<?php

require_once dirname(__DIR__).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\Cron;

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
            }
        }
    }
    function call_Daily(){

    }
    function call_Weekly(){

    }
    function call_Monthly(){

    }
}