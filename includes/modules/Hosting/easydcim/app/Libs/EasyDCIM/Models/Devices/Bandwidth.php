<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of Bandwidth
 *
 * @author Mateusz Pawłowski
 */
class Bandwidth extends Serializer
{

    /**
     * @var string
     */
    protected $startDate;

    /**
     * @var string
     */
    protected $endDate;

    /**
     * @var string
     */
    protected $units;

    /*
     * Start date of range
     * 
     * @params string $startDate
     * @return object $this;
     * 
     */

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /*
     * End date of range
     * 
     * @params string $endDate
     * @return object $this;
     * 
     */

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /*
     * Units
     * 
     * @params string $units
     * @return object $this;
     * 
     */

    public function setUnits($units)
    {
        $this->units = $units;
        return $this;
    }

}
