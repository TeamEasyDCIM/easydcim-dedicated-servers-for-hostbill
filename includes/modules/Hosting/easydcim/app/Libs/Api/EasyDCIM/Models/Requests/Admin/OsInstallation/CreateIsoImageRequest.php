<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for creating an ISO image
 */
class CreateIsoImageRequest
{
    public string $name;
    public string $isoUrl;
    public ?array $remoteApp;
    public ?string $availability;
    public ?array $users;
    /**
     * @param string $name ISO image name
     * @param string $isoUrl URL to the ISO file
     * @param array<int>|null $remoteApp Remote application IDs
     * @param string|null $availability Availability setting
     * @param array<int>|null $users User IDs that can access this ISO
     */
    public function __construct(string $name, string $isoUrl, ?array $remoteApp = null, ?string $availability = null, ?array $users = null)
    {
        $this->name = $name;
        $this->isoUrl = $isoUrl;
        $this->remoteApp = $remoteApp;
        $this->availability = $availability;
        $this->users = $users;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'iso_url' => $this->isoUrl,
            'remoteApp' => $this->remoteApp,
            'availability' => $this->availability,
            'users' => $this->users,
        ], fn($value) => $value !== null);
    }
}
