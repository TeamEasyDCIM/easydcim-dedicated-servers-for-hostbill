<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Models\ListWithType;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os\InstallParams;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os\Configuration;

class DefaultOptions
{
    /**
     * @var EasyDCIM
     */
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function getLocationList()
    {
        return $this->api->locations->getLists();
    }

    public function getModelList()
    {
        return $this->api->models->listServerModels();
    }

    public function getTemplateList($locationId)
    {
        try {
            $templateList = $this->api->os->getTemplateList();
            if ($locationId != '')
            {
                $provisioningServerId = $this->api->os->getOsTemplateForLocation($locationId)->id;

                foreach ($templateList as $key=>$value) {
                    if ($value->server_id != $provisioningServerId)
                    {
                        unset($templateList[$key]);
                    }
                }
                return $templateList;
            }
            return [];
        }catch(\Exception $ex)
        {
            return [];
        }

    }

    public function getAddonsList($templateId = null, $locationId)
    {
        try {
            $provisioningServerId = $this->api->os->getOsTemplateForLocation($locationId)->id;
            $model = new InstallParams();
            if ($templateId != null)
            {
                $model->setFilter([
                    'server_id'=>$provisioningServerId,
                    'template_id'=>$templateId,
                ]);
            }else{
                $model->setFilter([
                    'server_id'=>$provisioningServerId,
                ]);
            }
            $configuration = new Configuration();
            $configuration->setConfiguration($model);
            return $this->api->os->getAddonList($configuration);
        }catch(\Exception $ex)
        {
            return [];
        }
    }
}