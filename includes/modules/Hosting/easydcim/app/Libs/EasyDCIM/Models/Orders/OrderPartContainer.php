<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

class OrderPartContainer extends Serializer
{
    /*
    * Parts ID varibles
    */

    const HDD = 8;
    const SSD = 9;
    const RAM = 10;
    const CPU = 11;

    /**
     * @var array
     */
    protected $hdd;

    /**
     * @var array
     */
    protected $ssd;

    /**
     * @var array
     */
    protected $ram;

    /**
     * @var array
     */
    protected $cpu;

    /**
     * Set Easy HDD Part
     *
     * @param object $hdd insteandof OrderPart
     * @return object $this
     */
    public function setHdd(OrderPart $hdd)
    {
        $this->hdd = $hdd;
        return $this;
    }

    /**
     * Set Easy SSD Part
     *
     * @param object $ssd insteandof OrderPart
     * @return object $this
     */
    public function setSsd(OrderPart $ssd)
    {
        $this->ssd = $ssd;
        return $this;
    }

    /**
     * Set Easy RAM Part
     *
     * @param object $ram insteandof OrderPart
     * @return object $this
     */
    public function setRam(OrderPart $ram)
    {
        $this->ram = $ram;
        return $this;
    }

    /**
     * Set Easy CPU Part
     *
     * @param object $cpu insteandof OrderPart
     * @return object $this
     */
    public function setCpu(OrderPart $cpu)
    {
        $this->cpu = $cpu;
        return $this;
    }

    /**
     * Extended object serialization to specific array
     *
     * @return array
     */
    public function toArray()
    {
        $out = [];
        if (is_object($this->hdd))
        {
            $out[self::HDD] = $this->hdd->toArray();
        }
        if (is_object($this->ssd))
        {
            $out[self::SSD] = $this->ssd->toArray();
        }
        if (is_object($this->ram))
        {
            $out[self::RAM] = $this->ram->toArray();
        }
        if (is_object($this->cpu))
        {
            $out[self::CPU] = $this->cpu->toArray();
        }
        return $out;
    }
}