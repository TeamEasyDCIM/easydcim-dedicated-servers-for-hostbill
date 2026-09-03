<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Provisioning Server data
 */
class ProvisioningServerData
{
    public function __construct(
        public ?int $id,
        public ?int $appId,
        public ?string $name,
        public ?string $module,
        public ?ProvisioningServerConfigurationData $configuration,
        public ?int $enabled,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $config = Arr::get($data, 'configuration', []);
        if (is_array($config)) {
            $configuration = ProvisioningServerConfigurationData::fromArray($config);
        }else{
            $configuration = ProvisioningServerConfigurationData::fromArray([]);
        }

        return new self(
            id: Arr::get($data, 'id'),
            appId: Arr::get($data, 'app_id'),
            name: Arr::get($data, 'name'),
            module: Arr::get($data, 'module'),
            configuration: $configuration,
            enabled: Arr::get($data, 'enabled'),
        );
    }
}
