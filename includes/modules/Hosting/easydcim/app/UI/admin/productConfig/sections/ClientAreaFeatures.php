<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Field\ListFieldsRequest;

class ClientAreaFeatures
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
     * OS templates offered to clients, optionally narrowed to one location.
     *
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\OsTemplateData>
     */
    public function getOsTemplates($locationId = null)
    {
        return (new DefaultOptions($this->api))->getTemplateList($locationId);
    }

    /**
     * Metadata fields, used to pick which ones the client area shows.
     *
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Field\FieldData>
     */
    public function getFields()
    {
        try {
            return $this->api->admin()->fields()->listAll(new ListFieldsRequest());
        } catch (\Exception $ex) {
            return [];
        }
    }
}
