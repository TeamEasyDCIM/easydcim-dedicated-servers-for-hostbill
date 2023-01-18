<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models;

use JsonSerializable;

/**
 * Description of Serializer
 *
 * @author Mateusz Pawłowski
 */
class Serializer implements JsonSerializable
{

    /**
     * Serialize object to JSON object
     * 
     * @return JSON object
     */
    public function jsonSerialize()
    {
        $out = [];

        foreach (get_class_vars(get_called_class()) as $property => $value)
        {
            if (!isset($this->{$property}))
            {
                continue;
            }

            if (is_object($this->{$property}) && $this->{$property} instanceof \JsonSerializable)
            {
                $out[$property] = $this->{$property}->jsonSerialize();
            }
            else
            {
                $out[$property] = $this->{$property};
            }
        }
        return $out;
    }

    /**
     * Serialize object to array
     * 
     * @return JSON object
     */
    public function toArray()
    {
        $out = [];

        foreach (get_class_vars(get_called_class()) as $property => $value)
        {

            if (!isset($this->{$property}))
            {
                continue;
            }
            if (is_object($this->$property))
            {
                $out[$property] = $this->{$property}->toArray();
            }
            else
            {
                $out[$property] = $this->{$property};
            }
        }
        return $out;
    }

}
