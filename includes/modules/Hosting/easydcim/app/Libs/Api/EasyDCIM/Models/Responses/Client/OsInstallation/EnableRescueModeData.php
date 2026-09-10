<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class EnableRescueModeData
{
    public ?string $username;
    public ?string $password;
    public ?string $status;
    public function __construct(?string $username = null, ?string $password = null, ?string $status = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->status = $status;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'username'),
            Arr::get($data, 'password'),
            Arr::get($data, 'status')
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
