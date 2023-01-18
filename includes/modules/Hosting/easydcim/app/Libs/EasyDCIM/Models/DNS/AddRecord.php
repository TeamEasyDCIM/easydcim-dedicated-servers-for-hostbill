<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\DNS;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

class AddRecord extends Serializer
{
    /**
     * @var string $ip
     */
    protected $ip;

    /**
     * @var string $rdata
     */
    protected $rdata;

    /**
     * @var integer $ttl
     */
    protected $ttl;

    /**
     * DSet IP Address
     *
     * $params string $ip
     * @return object $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Set rData
     *
     * $params string $rdata
     * @return object $this
     */
    public function setRdata($rdata)
    {
        $this->rdata = $rdata;
        return $this;
    }

    /**
     * Set TTL
     *
     * $params integer $ttl
     * @return object $this
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
        return $this;
    }
}