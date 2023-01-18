<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of PowerPorts
 *
 * @author Mateusz Pawłowski
 */
class PowerPorts extends Serializer
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $action;

    /**
     * Power Ports ID
     * 
     * $params integer $id
     * @return object $this
     */
    public function setID($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Power Ports Actions
     * 
     * $params string $action
     * @return object $this
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

}
