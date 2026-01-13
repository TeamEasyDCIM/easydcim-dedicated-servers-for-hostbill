<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

class Filters extends Serializer
{

    /**
     * @var array|null
     */
    protected $ids;

    /**
     * @param array $ids
     */
    public function setIds(array $ids)
    {
        $this->ids = $ids;
    }

    /**
     * Extended object serialization to specific array
     *
     * @return array
     */
    public function toArray()
    {
        $out = [];
        foreach (parent::toArray() as $field => $value)
        {

            $out['filters'][$field] = $value;
        }

        return $out;
    }


}