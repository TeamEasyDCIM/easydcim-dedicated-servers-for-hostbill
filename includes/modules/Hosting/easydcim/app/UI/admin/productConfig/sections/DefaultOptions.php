<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemModel\ListItemModelsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Location\ListLocationsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\FindProvisioningServerRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\ListOsAddonsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\ListOsTemplatesRequest;

class DefaultOptions
{
    /**
     * Item type IDs that represent a whole server (as opposed to a part).
     */
    protected const SERVER_TYPE_IDS = ['4', '6'];

    /**
     * @var EasyDCIMClient
     */
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Location\LocationData>
     */
    public function getLocationList()
    {
        try {
            return $this->api->admin()->locations()->listAll(new ListLocationsRequest());
        } catch (\Exception $ex) {
            return [];
        }
    }

    /**
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemModel\ItemModelData>
     */
    public function getModelList()
    {
        try {
            $models = $this->api->admin()->itemModels()->listAll(new ListItemModelsRequest(null, null, null, null, implode(',', self::SERVER_TYPE_IDS), 'in', 'type_id'));

            return $models;
        } catch (\Exception $ex) {
            return [];
        }
    }

    /**
     * OS templates the location's provisioning server can actually install.
     *
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\OsTemplateData>
     */
    public function getTemplateList($locationId)
    {
        if ($locationId == '')
        {
            return [];
        }

        try {
            $provisioningServerId = $this->getProvisioningServerId($locationId);

            if ($provisioningServerId === null) {
                return [];
            }

            $templates = $this->api->admin()->osInstallation()->listAllOsTemplates(new ListOsTemplatesRequest());

            return array_values(array_filter($templates, function ($template) use ($provisioningServerId) {
                foreach ((array) $template->servers as $server) {
                    $serverId = is_object($server) ? ($server->id ?? null) : ($server['id'] ?? null);

                    if ($serverId !== null && (int) $serverId === (int) $provisioningServerId) {
                        return true;
                    }
                }

                return false;
            }));
        } catch (\Exception $ex) {
            return [];
        }
    }

    /**
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\OsAddonData>
     */
    public function getAddonsList($templateId, $locationId)
    {
        try {
            $provisioningServerId = $this->getProvisioningServerId($locationId);

            if ($provisioningServerId === null) {
                return [];
            }

            $addons = $this->api->admin()->osInstallation()->listAllOsAddons(new ListOsAddonsRequest(null, null, null, null, null, null, null, $templateId !== null && $templateId !== '' ? (int) $templateId : null));

            return array_values(array_filter($addons, function ($addon) use ($provisioningServerId) {
                return $addon->serverId === null || (int) $addon->serverId === (int) $provisioningServerId;
            }));
        } catch (\Exception $ex) {
            return [];
        }
    }

    /**
     * The provisioning server assigned to a location.
     */
    protected function getProvisioningServerId($locationId): ?int
    {
        if (empty($locationId)) {
            return null;
        }

        $response = $this->api->admin()->osInstallation()->findProvisioningServer(
            $locationId,
            new FindProvisioningServerRequest(FindProvisioningServerRequest::LOCATION_TYPE)
        );

        $id = $response->data === null ? null : $response->data->id;

        return $id !== null ? (int) $id : null;
    }
}
