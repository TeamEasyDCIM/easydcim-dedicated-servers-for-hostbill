<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of CreateOrder
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class OrderCreate extends Serializer
{

    /**
     * @var string
     */
    protected $module;

    /**
     * @var integer
     */
    protected $client;

    /**
     * @var integer
     */
    protected $auto_accept;

    /**
     * @var array
     */
    protected $criteria = [];

    /**
     * @var array
     */
    protected $service = [];

    /**
     * Easy Module name
     * 
     * $params string $module
     * @return object $this
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * Easy Client ID
     * 
     * $params integer $client
     * @return object $this
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Auto accept order
     * 
     * $params integer $autoAccept
     * @return object $this
     */
    public function setAutoAccept($autoAccept)
    {
        $this->auto_accept = $autoAccept;
        return $this;
    }

    /**
     * Service criteria
     * 
     * $params object $criteria insteadof OrderCriteria
     * @return object $this
     */
    public function setCriteria(OrderCriteria $criteria)
    {
        $this->criteria = $criteria;
        return $this;
    }

    /**
     * Service parameters
     * 
     * $params object $autoAccept insteadof OrderService
     * @return object $this
     */
    public function setService(OrderService $service)
    {
        $this->service = $service;
        return $this;
    }

}
