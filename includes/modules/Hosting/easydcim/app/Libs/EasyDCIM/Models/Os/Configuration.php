<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

class Configuration extends Serializer
{
    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * Configuration Container array
     *
     * $params object $configuration
     * @return object $this
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
        return $this;
    }
}