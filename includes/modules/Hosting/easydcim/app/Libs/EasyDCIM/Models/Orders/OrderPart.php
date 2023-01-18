<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders;

use Exception;

class OrderPart
{
    protected $availablePartTypes = [
        'hdd.size',
        'ssd.size',
        'ram.size',
        'cpu.cores',
    ];
    protected $model;
    protected $partType;

    public function setModels($models)
    {
        $this->model = $models;
        return $this;
    }

    public function setPartType($partType)
    {
        if (in_array($partType, $this->availablePartTypes))
        {
            $this->partType = $partType;
            return $this;
        }
        throw new Exception('Wrong part type');
    }

    public function toArray()
    {
        $models = [];
        $values = [];
        foreach ($this->model as $model) {
            $models[] = array_keys($model)[0];
            $values[] = $model[array_keys($model)[0]];
        }
        return [
            'model'         => $models,
            $this->partType => $values
        ];
    }
}