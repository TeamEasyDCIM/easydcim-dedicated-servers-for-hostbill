<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\User;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class TokenAbilityData
{
    public ?array $abilities;
    public ?bool $valid;
    public function __construct(?array $abilities, ?bool $valid)
    {
        $this->abilities = $abilities;
        $this->valid = $valid;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'abilities', []),
            Arr::get($data, 'valid', false)
        );
    }
}