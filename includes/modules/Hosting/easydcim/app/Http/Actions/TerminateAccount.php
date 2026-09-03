<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\Emails;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;

class TerminateAccount
{
    protected $module;

    protected $client;

    protected $params;

    protected $mailer;

    public function __construct($module, $mailer)
    {
        $this->module = $module;
        $this->mailer = $mailer;
        $this->params = $this->module->getAccount();
        $this->params['clientsdetails'] = $this->module->getClient();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($this->module->connection, $this->params);
    }

    /**
     * Either notify the administrators or run the termination against EasyDCIM,
     * depending on how the product is configured.
     */
    public function execute()
    {
        if ($this->client->getTerminateAction() === 1) {
            $this->sendTerminateEmail($this->client);

            return ['lastModuleAction' => 'TerminateAccount'];
        }

        $orderId = $this->client->getEasyOrderID();

        if (empty($orderId)) {
            throw new \Exception('Order ID is empty.');
        }

        $api = ApiClientFactory::fromClient($this->client);

        $response = $api->admin()->orders()->terminateService($orderId);

        if ($response->success === false) {
            throw new \Exception($response->message ?: 'Failed to terminate the service in EasyDCIM.');
        }

        return ['lastModuleAction' => 'TerminateAccount'];
    }

    /**
     * Send the configured notification to the selected administrators.
     */
    private function sendTerminateEmail(IClient $client)
    {
        $emailTemplates = new EmailNotifications();
        $emails = new Emails($this->mailer);

        $details = [
            'orderid'   => $client->getEasyOrderID(),
            'serverid'  => $client->getEasyServerID(),
            'accountid' => $client->getServiceID(),
        ];

        $clientData = [
            'firstname' => $client->getFirstName(),
            'lastname'  => $client->getLastName(),
        ];

        $emails->sendEmailForSelectedAdmins(
            $emailTemplates->getTemplate($client->getTerminateActiontemplate()),
            $details,
            $clientData,
            $emailTemplates->getAdminEmail($client->getAdminis())
        );
    }
}
