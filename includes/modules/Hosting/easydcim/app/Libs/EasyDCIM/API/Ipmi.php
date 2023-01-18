<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts\AbstractEasyDCIMAPI;

class Ipmi extends AbstractEasyDCIMAPI
{
    /**
     * EasyDCIM IPMI - Get Console Details
     * @documentation ??
     * @return JSON object
     * @throws string error
     */
    public function getConsoleDetails()
    {
        return $this->api->get()->execut('ipmi/device/' . $this->params->getEasyServerID() . '/console');
    }

    /**
     * EasyDCIM IPMI - Lunch Console
     * @documentation ??
     * @return JSON object
     * @throws string error
     */
    public function lunchConsole()
    {
        return $this->api->post()->execut('ipmi/device/' . $this->params->getEasyServerID() . '/console', false);
    }

    /**
     * EasyDCIM IPMI - Lunch Console
     * @documentation ??
     * @return JSON object
     * @throws string error
     */
    public function getNoVNCConsole()
    {
        return $this->api->get()->execut('ipmi/proxy/device/' . $this->params->getEasyServerID() . '/connect');
    }

    /**
     * EasyDCIM IPMI - Lunch Console
     * @documentation ??
     * @return JSON object
     * @throws string error
     */
    public function coldReset()
    {
        return $this->api->post()->execut('ipmi/device/' . $this->params->getEasyServerID() . '/reset-cold');
    }
}