<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

class IsoImagesRecord extends Serializer
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $iso_url
     */
    protected $iso_url;

    /**
     * @var integer $deviceId
     */
    protected $deviceId;

    /**
     * Set name
     *
     * $params string $name
     * @return object $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set isoURL
     *
     * $params string $iso_url
     * @return object $this
     */
    public function setIsoUrl($iso_url)
    {
        $this->iso_url = $iso_url;
        return $this;
    }

    /**
     * Set deviceId
     *
     * $params integer $deviceId
     * @return object $this
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
        return $this;
    }
}