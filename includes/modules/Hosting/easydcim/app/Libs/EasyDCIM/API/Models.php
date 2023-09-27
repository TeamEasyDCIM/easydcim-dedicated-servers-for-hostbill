<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts\AbstractEasyDCIMAPI;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Models\ListWithType;

/**
 * Description of Models
 *
 * @author Mateusz Pawłowski
 */
class Models extends AbstractEasyDCIMAPI
{

    /**
     * EasyDCIM ItemModel - List the Models for given type
     * @documentation https://www.easydcim.com/api/index.html#api-ItemModel-ItemModelsForType
     * @return JSON object
     * @throws error 
     */
    public function listModelsWithType(ListWithType $model)
    {

        return $this->api->post($model->toArray())->execut('model/for-type');
    }

    /**
     * EasyDCIM ItemModel - List the Models for given type
     * @documentation https://www.easydcim.com/api/index.html#api-ItemModel-ItemModelsForType
     * @return JSON object
     * @throws error
     */
    public function getModelList()
    {
        return $this->api->get()->execut('model');
    }

    /**
     * EasyDCIM json object
     * @documentation https://www.easydcim.com/api/index.html#api-ItemType
     * @return JSON object
     * @throws error
     */
    public function getTypeList()
    {
        return $this->api->get()->execut('type');
    }

    /**
     * EasyDCIM ItemModel - List the Models for Server and Blade type
     * @documentation https://www.easydcim.com/api/index.html#api-ItemModel-Index
     * @return JSON object
     * @throws error
     */
    public function listServerModels()
    {
        $filters = [
            'filters' => [
                'type_id' => [
                    '4','6'
                ]
            ]
        ];

        return $this->api->get()->execut('model?'. http_build_query($filters));
    }

}
