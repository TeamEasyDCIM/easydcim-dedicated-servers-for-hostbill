<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of Filters
 *
 * @author Mateusz Pawłowski
 */
class Filters extends Serializer
{

    /**
     * @var integer
     */
    protected $type_id;

    /**
     * @var integer
     */
    protected $colocation_id;

    /**
     * Easy device type ID
     * 
     * $params integer $typeID
     * @return object $this
     */
    public function setTypeID($typeID)
    {
        $this->type_id = $typeID;
        return $this;
    }

    /**
     * Easy Colocation device ID
     * 
     * $params integer $typeID
     * @return object $this
     */
    public function setColocationID($colocationID)
    {
        $this->colocation_id = $colocationID;
        return $this;
    }

    /**
     * Extended object serialization to specific array
     * 
     * @return array
     */
    public function toArray()
    {
        $out;
        foreach (parent::toArray() as $field => $value)
        {
            $out['filters[' . $field . ']'] = $value;
        }
        return $out;
    }

}
