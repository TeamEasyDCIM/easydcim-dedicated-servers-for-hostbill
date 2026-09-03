<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class EnableRescueModeData
{
    public function __construct(
        public ?string $username = null,
        public ?string $password = null,
        public ?string $status = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            username: Arr::get($data, 'username'),
            password: Arr::get($data, 'password'),
            status: Arr::get($data, 'status'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'username' => $this->username,
            'password' => $this->password,
            'status' => $this->status,
        ], fn($value) => $value !== null);
    }
}
