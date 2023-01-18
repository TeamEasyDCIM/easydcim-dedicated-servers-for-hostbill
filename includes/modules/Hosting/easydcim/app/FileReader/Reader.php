<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\FileReader;

use ModulesGarden\Servers\EasyDCIMv2\App\FileReader\Reader\Json;

/**
 * Description of Reader
 *
 * @author Rafał Ossowski <rafal.os@modulesgarden.com>
 */
class Reader
{

    /**
     * @param string $file
     * @return Json|null
     */
    public static function read($file, array $renderData = [])
    {
        $path = explode(DIRECTORY_SEPARATOR, $file);
        $file = end($path);
        array_pop($path);
        $path = implode(DIRECTORY_SEPARATOR, $path);
        $instance = null;
        $type = self::getType($file);

        if ($type == "json")
        {
            $instance = new Json($file, $path, $renderData);
        }

        return $instance;
    }

    private static function getType($file)
    {
        $type  = null;
        $array = explode('.', $file);
        if (is_array($array))
        {
            $type = end($array);
        }

        return strtolower($type);
    }
}
