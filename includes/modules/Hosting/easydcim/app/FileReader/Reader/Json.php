<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\FileReader\Reader;

/**
 * Description of Json
 *
 * @author Rafał Ossowski <rafal.os@modulesgarden.com>
 */
class Json extends AbstractType
{

    protected function loadFile()
    {
        $return = [];
        try
        {
            if (file_exists($this->path . DS . $this->file))
            {
                $readFile = file_get_contents($this->path . DS . $this->file);
                $return   = json_decode($readFile, true);
            }
        }
        catch (\Exception $e)
        {
        }

        $this->data = $return;
    }
}
