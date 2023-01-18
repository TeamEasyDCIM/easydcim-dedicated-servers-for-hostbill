<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Locations;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of Create
 *
 * @author Mateusz Pawłowski
 */
class Create extends Serializer
{

    /**
     * @var string
     */
    protected $name;

    /**
     * Easy location name
     * 
     * $params string $name
     * @return object $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}
