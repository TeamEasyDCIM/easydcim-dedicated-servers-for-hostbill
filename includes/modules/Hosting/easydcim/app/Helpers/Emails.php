<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

class Emails
{
    protected $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendServerCreateEmail(IClient $client,$template,$clientData,$service,$server)
    {
        $email = $client->getEmail();
        $this->mailer->loadFromTemplate($template->tplname, $template->for);
        $this->mailer->template->assign("service", $service);
        $this->mailer->template->assign("server", $server);
        $this->mailer->template->assign("client", $clientData);
        $this->mailer->fetchTpl();
        $this->mailer->AddAddress($email);
        $this->mailer->Send();
    }

    public function sendEmailForSelectedAdmins($template,$details,$clientData,$email)
    {
        $this->mailer->loadFromTemplate($template->tplname, $template->for);
        $this->mailer->template->assign("details", $details);
        $this->mailer->template->assign("client", $clientData);
        $this->mailer->fetchTpl();
        $this->mailer->AddAddress($email);
        $this->mailer->Send();
    }
}