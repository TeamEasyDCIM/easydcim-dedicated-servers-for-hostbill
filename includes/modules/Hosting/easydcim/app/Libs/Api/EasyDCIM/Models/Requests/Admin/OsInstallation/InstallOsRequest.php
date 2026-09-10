<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for installing OS on a device
 */
class InstallOsRequest
{
    public int $template;
    public ?string $hostname;
    public ?string $username;
    public ?string $password;
    public ?string $rootPassword;
    public ?int $diskAddon;
    public ?array $extras;
    public ?array $sshKeys;
    /**
     * @param int $template Template ID
     * @param string|null $hostname Hostname
     * @param string|null $username Username
     * @param string|null $password User password
     * @param string|null $rootPassword Root password
     * @param int|null $diskAddon Disk addon ID
     * @param array<int>|null $extras Extra addon IDs
     * @param array<int>|null $sshKeys SSH key IDs
     */
    public function __construct(int $template, ?string $hostname = null, ?string $username = null, ?string $password = null, ?string $rootPassword = null, ?int $diskAddon = null, ?array $extras = null, ?array $sshKeys = null)
    {
        $this->template = $template;
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->rootPassword = $rootPassword;
        $this->diskAddon = $diskAddon;
        $this->extras = $extras;
        $this->sshKeys = $sshKeys;
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
            'root_password' => $this->rootPassword,
            'disk_addon' => $this->diskAddon,
            'extras' => $this->extras,
            'ssh_keys' => $this->sshKeys,
        ], fn($value) => $value !== null);
    }
}
