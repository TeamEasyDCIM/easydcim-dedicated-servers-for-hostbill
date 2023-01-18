<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts\AbstractEasyDCIMAPI;

/**
 * Description of Service
 *
 * @author Mateusz Pawłowski
 * 
 */
class Service extends AbstractEasyDCIMAPI
{

    /**
     * EasyDCIM Service - List the services access levels
     * @documentation https://www.easydcim.com/api/index.html#api-Service-Index
     * @return JSON object
     * @throws error
     */
    public function getAccessLevelList()
    {
        return $this->api->get()->execut('service-access-level');
    }

    /**
     * EasyDCIM Service - List the services
     * @documentation https://www.easydcim.com/api/index.html#api-Service-Index
     * @return JSON object
     * @throws error
     */
    public function getSetviceList()
    {
        return $this->api->get()->execut('service');
    }

}
