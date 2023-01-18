<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Models;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of Create
 *
 * @author Mateusz Pawłowski
 */
class ListWithType extends Serializer
{

    /**
     * @var string
     */
    protected $type;

    /**
     * Easy model type name
     * 
     * $params string $type
     * @return object $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

}
