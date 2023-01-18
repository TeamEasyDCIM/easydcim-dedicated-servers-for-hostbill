<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM;

use Exception;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\Connection;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\Device;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\DnsManager;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\Ipmi;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\Locations;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\Models;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\Order;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\Os;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\Service;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\System;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\User;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\PasswordManagement;

/**
 * Description of EasyDCIM
 *
 * @author Mateusz Pawłowski
 * 
 * @property Device $device
 * @property Locations $locations
 * @property PasswordManagement $passwordManagement
 * @property Models $models
 * @property Order $order
 * @property Service $service
 * @property System $system
 * @property User $user
 * @property Os $os
 * @property Ipmi $ipmi
 * @property DnsManager $dnsManager
 */

class EasyDCIM
{

    /**
     * ClientAdapter object
     * 
     * @var object insteadof ClientAdapter
     */
    private $params;

    /**
     * Connection object
     * 
     * @var object insteadof Connection
     */
    private $api;

    /**
     * Easy DCIM Create ClientAdaper
     * 
     * @param object $client insteadof ClientAdapter
     */
    public function __construct(IClient $client)
    {
        $this->params = $client;
    }

    /**
     * 
     * Easy DCIM Set API Connection and Validate required fields
     * 
     */
    private function setAPI()
    {
        if (!$this->params->getServerHostname())
        {
            throw new Exception('API: Server IP and hostname is empty.');
        }
        if (!$this->params->getServerAPIKey())
        {
            throw new Exception('API: Server API Key is empty.');
        }
        $this->api = new Connection($this->params->getServerHostname(), $this->params->getServerAPIKey());
    }

    /**
     * Easy DCIM API magic method handling
     * 
     * @param string
     * @return object
     */
    public function __get($function)
    {
        return $this->getClass($function);
    }

    /**
     * Easy DCIM API method handling
     * 
     * @param string
     * @return object
     */
    public function getClass($function)
    {
        if (is_null($function))
        {
            throw new Exception('API: The method cannot be empty.');
        }
        $className = __NAMESPACE__ . '\API\\' . ucfirst($function);
        if (!class_exists($className))
        {
            throw new Exception('API: Class ' . ucfirst($function) . ' does not exists.');
        }

        $this->setAPI();
        return new $className($this->api, $this->params);
    }

}
