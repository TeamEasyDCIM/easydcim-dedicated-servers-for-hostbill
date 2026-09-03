<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation;

class InstallOsRequest
{
    /**
     * @param array<int>|null $sshKeys
     * @param array<int>|null $extras
     */
    public function __construct(
        public int $template,
        public string $hostname,
        public ?string $username = null,
        public ?string $password = null,
        public ?string $root_password = null,
        public ?array $sshKeys = null,
        public ?int $diskAddon = null,
        public ?array $extras = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'template' => $this->template,
            'hostname' => $this->hostname,
            'username' => $this->username,
            'password' => $this->password,
            'root_password' => $this->root_password,
            'ssh_keys' => $this->sshKeys,
            'disk_addon' => $this->diskAddon,
            'extras' => $this->extras,
        ], fn($value) => $value !== null);
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            template: $data['template'],
            hostname: $data['hostname'],
            username: $data['username'] ?? null,
            password: $data['password'] ?? null,
            sshKeys: $data['ssh_keys'] ?? $data['sshKeys'] ?? null,
            diskAddon: $data['disk_addon'] ?? $data['diskAddon'] ?? null,
            extras: $data['extras'] ?? null,
        );
    }
}
