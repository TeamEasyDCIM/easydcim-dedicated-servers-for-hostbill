<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts\AbstractEasyDCIMAPI;

/**
 * Description of System
 *
 * @author Mateusz Pawłowski
 */
class System extends AbstractEasyDCIMAPI
{

    /**
     * EasyDCIM System - Get system version
     * @documentation https://www.easydcim.com/api/index.html#api-System-Retrieve
     * @return JSON object
     * @throws string error
     */
    public function getVersion()
    {
        return $this->api->get()->execut('system/version');
    }
    
    
    public function getFields(){
        return $this->api->get()->execut('fields');
    }

    public function showField($fieldId){
        return $this->api->get()->execut('fields/'.$fieldId);
    }

    /**
     * EasyDCIM System - Get activated modules
     * @documentation https://www.easydcim.com/api/index.html#api-System-Modules
     * @return JSON object
     * @throws string error
     */
    public function getModules()
    {
        return $this->api->get()->execut('system/modules');
    }

}
