<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

class Metadata extends Serializer
{
    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $value;

    /*
     * Set Slug name
     *
     * @param string $value
     *
     * @return object $this
     */

    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /*
     * Set value
     *
     * @param string $value
     *
     * @return object $this
     */

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}