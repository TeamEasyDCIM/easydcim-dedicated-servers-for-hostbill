<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of CreateOrder
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class OrderCriteria extends Serializer
{

    /**
     * @var integer
     */
    protected $model;

    /**
     * @var integer
     */
    protected $location;

    /**
     * @var integer
     */
    protected $require_parts;

    /**
     * @var array
     */
    protected $parts = [];

    /**
     * @var integer
     */
    protected $require_pdu;

    /**
     * @var integer
     */
    protected $require_switch;

    /**
     * Easy Model ID
     * 
     * $params integer $model
     * @return object $this
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Easy Location ID
     * 
     * $params integer $location
     * @return object $this
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Require Parts
     * 
     * $params integer $requireParts
     * @return object $this
     */
    public function setRequireParts($requireParts)
    {
        $this->require_parts = $requireParts;
        return $this;
    }

    /**
     * Parts
     * 
     * $params object $parts
     * @return object $this
     */
    public function setParts($parts)
    {
        $this->parts = $parts;
        return $this;
    }

    /**
     * Require Pdu
     * 
     * $params integer $requirePdu
     * @return object $this
     */
    public function setRequirePdu($requirePdu)
    {
        $this->require_pdu = $requirePdu;
        return $this;
    }

    /**
     * Require Switch
     * 
     * $params integer $requireSwitch
     * @return object $this
     */
    public function setRequireSwitch($requireSwitch)
    {
        $this->require_switch = $requireSwitch;
        return $this;
    }

}
