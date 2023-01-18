<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts\AbstractEasyDCIMAPI;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices\Bandwidth;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices\DataContainer;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices\Filters;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices\Graph;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices\Metadata;

/**
 * Description of Device
 *
 * @author Mateusz Pawłowski
 */
class Device extends AbstractEasyDCIMAPI
{

    /**
     * EasyDCIM Device - Show device information
     * @documentation https://www.easydcim.com/api/index.html#api-Device-Retrieve
     * @return JSON object
     * @throws string error
     */
    public function getInformation($deviceID = null)
    {
        $deviceID = ($deviceID) ?: $this->params->getEasyServerID();
        return $this->api->get()->execut('device/' . $deviceID);
    }

    /**
     * EasyDCIM Device - Show available graphs
     * @documentation https://www.easydcim.com/api/index.html#api-Device-deviceAvailableGraphs
     * @return JSON object
     * @throws string error
     */
    public function getAvailableGraphs()
    {

        return $this->api->get()->execut('device/' . $this->params->getEasyServerID() . '/graphs');
    }

    /**
     * EasyDCIM Device - Render specified graphs
     * @documentation https://www.easydcim.com/api/index.html#api-Device-deviceRenderGraph
     * @return JSON object
     * @throws string error
     */
    public function renderGraphs(Graph $model)
    {
        return $this->api->post($model->toArray())->execut('device/' . $this->params->getEasyServerID() . '/graph');
    }

    /**
     * EasyDCIM Device - Device bandwidth
     * @documentation https://www.easydcim.com/api/index.html#api-Device-DeviceBandwidth
     * @return JSON object
     * @throws string error
     */
    public function bandwidth(Bandwidth $model, $deviceID = null)
    {
        $deviceID = ($deviceID) ?: $this->params->getEasyServerID();
        return $this->api->post($model->toArray())->execut('device/' . $deviceID . '/bandwidth');
    }

    /**
     * EasyDCIM Device - Device bandwidth
     * @documentation https://www.easydcim.com/api/index.html#api-Device-DeviceBandwidth
     * @return JSON object
     * @throws string error
     */
    public function getBandwidth($deviceID = null)
    {
        $deviceID = ($deviceID) ?: $this->params->getEasyServerID();
        return $this->api->post()->execut('device/' . $deviceID . '/bandwidth');
    }

    /**
     * EasyDCIM Device - Render specified graphs
     * @documentation https://www.easydcim.com/api/index.html#api-Device-deviceRenderGraph
     * @return JSON object
     * @throws string error
     */
    public function renderSpecifiedGraphs(Graph $model)
    {
        return $this->api->post($model->toArray())->execut('graphs/' . $this->params->getEasyServerID() . '/device');
    }

    /**
     * EasyDCIM Device - Device power usage
     * @documentation https://www.easydcim.com/api/index.html#api-Device-DevicePowerUsage
     * @return JSON object
     * @throws string error
     */
    public function powerUsage(Bandwidth $model, $deviceID = null)
    {
        $deviceID = ($deviceID) ?: $this->params->getEasyServerID();
        return $this->api->post($model->toArray())->execut('device/' . $deviceID . '/power-usage');
    }

    /**
     * EasyDCIM Device - List the devices
     * @documentation https://www.easydcim.com/api/index.html#api-Device-Index
     * @return JSON object
     * @throws string error
     */
    public function getDevice(Filters $model)
    {
        return $this->api->get($model->toArray())->execut('device');
    }

    /**
     * EasyDCIM Port - set Power Ports
     * @documentation - ??
     * @return JSON object
     * @throws string error
     */
    public function setPower(DataContainer $model, $deviceID = null)
    {
        $deviceID = ($deviceID) ?: $this->params->getEasyServerID();
        return $this->api->post($model->toArray())->execut('device/' . $deviceID . '/power-port/action');
    }

    /**
     * EasyDCIM Port - get Power Ports
     * @documentation - https://www.easydcim.com/api/index.html#api-PowerPort-Index
     * @return JSON object
     * @throws string error
     */
    public function getPortList($deviceID = null)
    {
        $deviceID = ($deviceID) ?: $this->params->getEasyServerID();
        return $this->api->get()->execut('device/' . $deviceID . '/power-port');
    }

    /**
     * EasyDCIM Device - Assign specified metadata to device
     * @documentation - https://www.easydcim.com/api/index.html#api-Device-assignMetadata
     * @return JSON object
     * @throws string error
     */
    public function assignMetadata(Metadata $model)
    {
        return $this->api->post($model->toArray())->execut('device/' . $this->params->getEasyServerID() . '/metadata/assign');
    }

    /**
     * EasyDCIM Device - Power up device
     * @documentation - https://www.easydcim.com/api/index.html#api-Device-deviceBoot
     * @return JSON object
     * @throws string error
     */
    public function powerOn()
    {
        return $this->api->post()->execut('device/' . $this->params->getEasyServerID() . '/power/up');
    }

    /**
     * EasyDCIM Device - Shutdown the device
     * @documentation - https://www.easydcim.com/api/index.html#api-Device-deviceShutdown
     * @return JSON object
     * @throws string error
     */
    public function powerOff()
    {
        return $this->api->post()->execut('device/' . $this->params->getEasyServerID() . '/power/shutdown');
    }

    /**
     * EasyDCIM Device - Reboot the device
     * @documentation - https://www.easydcim.com/api/index.html#api-Device-deviceReboot
     * @return JSON object
     * @throws string error
     */
    public function reboot()
    {
        return $this->api->post()->execut('device/' . $this->params->getEasyServerID() . '/power/reboot');
    }

    /**
     * EasyDCIM Device - Update device
     * @documentation - https://www.easydcim.com/api/index.html#api-Device-Update
     * @return JSON object
     * @throws string error
     */
    public function update(DataContainer $model)
    {
        return $this->api->put($model->toArray())->execut('device/' . $this->params->getEasyServerID());
    }

    /**
     * EasyDCIM Device - Get Device Rescue Mode status
     * @documentation  https://www.easydcim.com/api/#api-Os_Installation-rescueModeStatus
     * @return boolean
     * @throws string error
     */
    public function getRescueModeStatus()
    {
        return $this->api->get()->execut('os/device/' . $this->params->getEasyServerID() . '/os/rescue')->rescueMode;
    }

    /**
     * EasyDCIM Device - Change Device Rescue Mode status
     * @documentation  https://www.easydcim.com/api/#api-Os_Installation-rescueModeDisable
     * @return JSON object
     * @throws string error
     */
    public function changeRescueModeStatus($change = 'disable')
    {
        return $this->api->post()->execut('os/device/' . $this->params->getEasyServerID() . '/os/rescue/' . $change)->rescueMode;
    }

}
