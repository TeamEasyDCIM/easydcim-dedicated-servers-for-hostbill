<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for updating an ISO image
 */
class UpdateIsoImageRequest
{
    /**
     * @param string|null $name ISO image name
     * @param array<int>|null $remoteApp Remote application IDs
     * @param string|null $availability Availability setting
     * @param array<int>|null $users User IDs that can access this ISO
     */
    public function __construct(
        public ?string $name = null,
        public ?array $remoteApp = null,
        public ?string $availability = null,
        public ?array $users = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'remoteApp' => $this->remoteApp,
            'availability' => $this->availability,
            'users' => $this->users,
        ], fn($value) => $value !== null);
    }
}
