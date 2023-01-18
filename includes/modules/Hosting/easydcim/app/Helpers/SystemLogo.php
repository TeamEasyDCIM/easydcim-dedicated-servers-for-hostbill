<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

class SystemLogo
{
    /*
         * Matched logo to name
         *
         * @param string $systemName
         * @return string
         */

    public static function getLogo($systemName)
    {
        $systemName = strtolower($systemName);
        $logoDir    = './includes' . DS . 'modules' . DS . 'Hosting' . DS . 'easydcim' . DS . 'templates' . DS . 'assets' . DS . 'img';
        $logo       = self::searchLogo($logoDir, $systemName);
        return $logoDir . DS . $logo;
    }

    /*
     * Get all logo images
     *
     * @param string $logoDir
     * @return array $files
     */

    private static function getLogoFiles($logoDir)
    {
        $files = scandir($logoDir);
        foreach ($files as $key => $value)
        {
            if ($value == "." || $value == "..")
            {
                unset($files[$key]);
            }
        }
        return $files;
    }

    /*
     * Search matched logo
     *
     * $param string $logoDir, $name
     * @return string $logo
     */

    private static function searchLogo($logoDir, $name)
    {
        $logoArray = self::getLogoFiles($logoDir);
        foreach ($logoArray as $logo)
        {
            $logoName = explode(".", $logo)[0];

            if (is_numeric(strpos($name, $logoName)))
            {
                return $logo;
            }
        }
        return 'windows.jpg';
    }
}