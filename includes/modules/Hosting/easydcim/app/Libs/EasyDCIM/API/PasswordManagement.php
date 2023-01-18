<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts\AbstractEasyDCIMAPI;

class PasswordManagement extends AbstractEasyDCIMAPI
{
    /**
     * @return mixed
     */
    public function getAccessList()
    {
        return $this->api->get()->execut('pm/access');
    }
}