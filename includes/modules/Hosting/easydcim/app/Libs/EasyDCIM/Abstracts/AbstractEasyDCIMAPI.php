<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\Connection;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

/**
 * Description of AbstractEasyDCIMAPI
 *
 * @author Mateusz Pawłowski
 */
abstract class AbstractEasyDCIMAPI
{

    /**
     * ClientAdapter object
     * 
     * @var object insteadof ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter
     */
    protected $params;

    /**
     * Connection object
     * 
     * @var object insteadof \ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\Connection
     */
    protected $api;

    /**
     * Connection object
     * 
     * @params object $api insteadof \ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API\Connection, $client insteadof \ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter
     */
    public function __construct(Connection $api, IClient $client)
    {
        $this->api    = $api;
        $this->params = $client;
    }

}
