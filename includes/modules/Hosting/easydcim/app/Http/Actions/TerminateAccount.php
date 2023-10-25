<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\Emails;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;

use Illuminate\Database\Capsule\Manager as DB;

class TerminateAccount
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

    public function __construct($module,$mailer)
    {
        $this->module = $module;
        $this->mailer = $mailer;
        $this->params = $this->module->getAccount();
        $this->params['clientsdetails'] = $this->module->getClient();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($this->module->connection,$this->params);
    }

    public function execute()
    {
        if ($this->client->getTerminateAction() === 1)
        {
            $this->sendTerminateEmail($this->client);
        }
        else
        {
            $api = new EasyDCIM($this->client);
            $api->order->terminate();
        }

        return [
            'lastModuleAction' => 'TerminateAccount'
        ];
    }

    /*
     * Send suspension Email to admin
     */
    private function sendTerminateEmail(IClient $client)
    {
        $emailTemplates = new EmailNotifications();
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
        $emails->sendEmailForSelectedAdmins($emailTemplates->getTemplate($client->getTerminateActiontemplate()),$details,$clientData,$emailTemplates->getAdminEmail($client->getAdminis()));
    }
}