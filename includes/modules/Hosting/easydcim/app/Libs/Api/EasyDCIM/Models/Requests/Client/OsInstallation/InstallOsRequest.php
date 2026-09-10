<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation;

class InstallOsRequest
{
    public int $template;
    public string $hostname;
    public ?string $username;
    public ?string $password;
    public ?string $root_password;
    public ?array $sshKeys;
    public ?int $diskAddon;
    public ?array $extras;
    /**
     * @param array<int>|null $sshKeys
     * @param array<int>|null $extras
     */
    public function __construct(int $template, string $hostname, ?string $username = null, ?string $password = null, ?string $root_password = null, ?array $sshKeys = null, ?int $diskAddon = null, ?array $extras = null)
    {
        $this->template = $template;
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->root_password = $root_password;
        $this->sshKeys = $sshKeys;
        $this->diskAddon = $diskAddon;
        $this->extras = $extras;
    }

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
        return new self($data['template'], $data['hostname'], $data['username'] ?? null, $data['password'] ?? null, null, $data['ssh_keys'] ?? $data['sshKeys'] ?? null, $data['disk_addon'] ?? $data['diskAddon'] ?? null, $data['extras'] ?? null);
    }
}
