<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Enum;

abstract class Enum
{
    static function getKeys(){
        $class = new ReflectionClass(get_called_class());
        return array_keys($class->getConstants());
    }
}
