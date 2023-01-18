<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts\AbstractEasyDCIMAPI;

/**
 * Description of Locations
 *
 * @author Mateusz Pawłowski
 */
class Locations extends AbstractEasyDCIMAPI
{

    /**
     * EasyDCIM Location - List the locations
     * @documentation https://www.easydcim.com/api/index.html#api-Location-Index
     * @return JSON objects
     * @throws error 
     */
    public function getLists()
    {
        return $this->api->get()->execut('location');
    }

}
