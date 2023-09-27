<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts\AbstractEasyDCIMAPI;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os\Configuration;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os\DataContainer;

class Os extends AbstractEasyDCIMAPI
{
    /**
     * EasyDCIM OsInstallation - List Os Template
     * @documentation ??
     * @return JSON object
     * @throws error
     *
     */
    public function getTemplateList()
    {
        return $this->api->get()->execut('os/template');
    }

    /**
     * EasyDCIM OsInstallation - List Os Template
     * @documentation https://www.easydcim.com/api/index.html#api-OsInstallation-findOsServerForLocation
     * @return JSON object
     * @throws error
     *
     */
    public function getOsTemplateForLocation($locationID = null)
    {
        $locationID = ($locationID) ?: $this->params->getLocationID();
        return $this->api->get()->execut('os/server/location/' . $locationID);
    }

    /**
     * EasyDCIM OsInstallation - Cancel Operating System Installation
     * @documentation https://www.easydcim.com/api/index.html#api-OsInstallation-cancelInstallOperatingSystem
     * @return JSON object
     * @throws error
     */
    public function cancelInstal()
    {
        return $this->api->post()->execut('os/device/' . $this->params->getEasyServerID() . '/os/install/cancel');
    }

    /**
     * EasyDCIM OsInstallation - Install Information
     * @documentation https://www.easydcim.com/api/index.html#api-OsInstallation-installInformation
     * @return JSON object
     * @throws error
     */
    public function installInformation()
    {
        return $this->api->get()->execut('os/device/' . $this->params->getEasyServerID() . '/os/install/information');
    }

    /**
     * EasyDCIM OsInstallation - Install Operating System
     * @documentation https://www.easydcim.com/api/index.html#api-OsInstallation-installOperatingSystem
     * @return JSON object
     * @throws error
     *
     * TO DO create install Model
     */
    public function install(Configuration $model)
    {
        return $this->api->post($model->toArray())->execut('os/device/' . $this->params->getEasyServerID() . '/os/install');
    }

    /**
     * EasyDCIM OsInstallation - List Os Addons
     * @documentation https://www.easydcim.com/api/index.html#api-OsInstallation-index
     * @return JSON object
     * @throws error
     *
     */
    public function getAddonList(Configuration $model)
    {
        return $this->api->get($model->toArray()['configuration'])->execut('os/addon');
    }

    /**
     * EasyDCIM OsInstallation - List Iso Images
     * @documentation ??
     * @return JSON object
     * @throws error
     *
     */
    public function getIsoImagesForDevice($deviceId)
    {
        return $this->api->get()->execut('os/isoimages/device/'.$deviceId);
    }

    /**
     * EasyDCIM OsInstallation - Create Iso Image
     * @documentation https://www.easydcim.com/api/index.html#api-OsInstallation-installOperatingSystem
     * @return JSON object
     * @throws error
     */
    public function createIsoImage(DataContainer $model)
    {
        return $this->api->post($model->toArray())->execut('os/isoimages');
    }

    /**
     * EasyDCIM OsInstallation - Update Iso Image
     * @documentation https://www.easydcim.com/api/index.html#api-OsInstallation-installOperatingSystem
     * @return JSON object
     * @throws error
     */
    public function updateIsoImage(DataContainer $model,$id)
    {
        return $this->api->put($model->toArray())->execut('os/isoimages/'.$id);
    }

    /**
     * EasyDCIM OsInstallation - Delete Iso Image
     * @documentation https://www.easydcim.com/api/index.html#api-OsInstallation-installOperatingSystem
     * @return JSON object
     * @throws error
     */
    public function deleteIsoImage($id)
    {
        return $this->api->delete()->execut('os/isoimages/'.$id);
    }
}