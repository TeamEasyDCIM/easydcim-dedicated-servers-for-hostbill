<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for installing OS on a device
 */
class InstallOsRequest
{
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
    public function __construct(
        public int $template,
        public ?string $hostname = null,
        public ?string $username = null,
        public ?string $password = null,
        public ?string $rootPassword = null,
        public ?int $diskAddon = null,
        public ?array $extras = null,
        public ?array $sshKeys = null,
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
            'root_password' => $this->rootPassword,
            'disk_addon' => $this->diskAddon,
            'extras' => $this->extras,
            'ssh_keys' => $this->sshKeys,
        ], fn($value) => $value !== null);
    }
}
