<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ServiceAccessLevel\ListServiceAccessLevelsRequest;

class AutomationSettings
{
    /**
     * @var EasyDCIMClient
     */
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ServiceAccessLevel\ServiceAccessLevelData>
     */
    public function getAccessLevelList()
    {
        try {
            return $this->api->admin()->accessLevels()->listAll(new ListServiceAccessLevelsRequest());
        } catch (\Exception $ex) {
            return [];
        }
    }
}
