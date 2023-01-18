<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of Graph
 *
 * @author Mateusz Pawłowski
 */
class Graph extends Serializer
{

    /**
     * @var string
     */
    protected $type;

    /**
     * @var integer
     */
    protected $export;

    /**
     * @var integer
     */
    protected $width;

    /**
     * @var integer
     */
    protected $height;

    /**
     * @var string
     */
    protected $start;

    /**
     * @var string
     */
    protected $end;

    /**
     * Easy DCIM graph type name 
     * 
     * $params string $type
     * @return object $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Export of graph
     *
     * $params integer $width
     * @return object $this
     */
    public function setExport($export)
    {
        $this->export = $export;
        return $this;
    }

    /**
     * Width of graph
     * 
     * $params integer $width
     * @return object $this
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Height of graph
     * 
     * $params integer $height
     * @return object $this
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Start date of range
     * 
     * $params string $start
     * @return object $this
     */
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }

    /**
     * End date of range
     * 
     * $params string $end
     * @return object $this
     */
    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }

}
