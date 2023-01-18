<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\Emails;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Database\Database;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;

class SuspendAccount
{
    /**
     * @var
     */
    protected $module;

    /**
     * @var ClientAdapter
     */
    protected $client;
    /**
     * @var
     */
    protected $params;
    protected $mailer;
    protected $db;

    public function __construct($module,$mailer)
    {
        $this->module = $module;
        $this->mailer = $mailer;
        $this->params = $this->module->getAccount();
        $this->params['clientsdetails'] = $this->module->getClient();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($this->module->connection,$this->params);
        $db = new Database();
        $this->db = $db->getConnection();
    }

    public function execute()
    {
        if ($this->client->getSuspendAction() === 1)
        {
            $this->sendSuspendEmail($this->client);
        }
        else
        {
            $api = new EasyDCIM($this->client);
            $api->order->suspend();
        }
        return [
            'lastModuleAction' => 'SuspendAccount'
        ];
    }

    /*
     * Send suspension Email to admin
     */

    private function sendSuspendEmail(IClient $client)
    {
        $emailTemplates = new EmailNotifications($this->db);
        $emails = new Emails($this->mailer);
        $details = [
            'orderid'=>$client->getEasyOrderID(),
            'serverid'=>$client->getEasyServerID(),
            'accountid'=>$client->getServiceID(),
        ];
        $clientData = [
          'firstname'=>$client->getFirstName(),
          'lastname'=>$client->getLastName(),
        ];
        $emails->sendEmailForSelectedAdmins($emailTemplates->getTemplate($client->getSuspendActionTemplate()),$details,$clientData,$emailTemplates->getAdminEmail($client->getAdminis()));
    }
}