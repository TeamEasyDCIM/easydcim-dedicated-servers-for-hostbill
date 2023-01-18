<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of DataContainer
 *
 * @author Mateusz Pawłowski
 */
class DataContainer extends Serializer
{

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Data Container array
     * 
     * $params object $data
     * @return object $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

}
