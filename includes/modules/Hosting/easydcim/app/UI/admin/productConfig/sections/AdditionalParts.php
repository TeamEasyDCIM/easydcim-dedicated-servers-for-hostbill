<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Models\ListWithType;

class AdditionalParts
{
    /**
     * @var EasyDCIM
     */
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function getTypes($type) {
        if ($type != '')
        {
            self::jsonEncode($this->getOptions($type));
        }
        else
        {
            self::jsonEncode([]);
        }
    }

    public function getParts($data)
    {
        if (is_array($data))
        {
            self::jsonEncode($data);
        }else{
            self::jsonEncode([]);
        }
    }

    protected function getOptions($type) {
        $options = [];
        $model = new ListWithType();
        $model->setType($type);

        foreach ($this->api->models->listModelsWithType($model) as $value) {
            $options[] = [
                'key' => $value->id,
                'value' => $value->name
            ];
        }

        return $options;
    }

    /**
     * @param array $data
     */
    public static function jsonEncode(array $data)
    {

        ob_clean();
        echo(json_encode([
            'data'=>$data
        ]));
        die;
    }
}