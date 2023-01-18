<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;

class ClientAreaFeatures
{
    /**
     * @var EasyDCIM
     */
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function getOsTemplates(){
        return $this->api->os->getTemplateList();
    }

    public function getFields(){
        return $this->api->system->getFields();
    }
}