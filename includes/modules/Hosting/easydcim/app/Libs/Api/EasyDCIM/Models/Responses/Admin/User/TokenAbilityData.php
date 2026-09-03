<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\User;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class TokenAbilityData
{
    public function __construct(
        public ?array $abilities,
        public ?bool $valid,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            abilities: Arr::get($data, 'abilities', []),
            valid: Arr::get($data, 'valid', false),
        );
    }
}