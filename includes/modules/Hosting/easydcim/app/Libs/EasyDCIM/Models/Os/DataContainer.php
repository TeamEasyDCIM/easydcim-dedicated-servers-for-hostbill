<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

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