<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Provisioning Server data
 */
class ProvisioningServerData
{
    public ?int $id;
    public ?int $appId;
    public ?string $name;
    public ?string $module;
    public ?ProvisioningServerConfigurationData $configuration;
    public ?int $enabled;
    public function __construct(?int $id, ?int $appId, ?string $name, ?string $module, ?ProvisioningServerConfigurationData $configuration, ?int $enabled)
    {
        $this->id = $id;
        $this->appId = $appId;
        $this->name = $name;
        $this->module = $module;
        $this->configuration = $configuration;
        $this->enabled = $enabled;
    }

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
            Arr::get($data, 'id'),
            Arr::get($data, 'app_id'),
            Arr::get($data, 'name'),
            Arr::get($data, 'module'),
            $configuration,
            Arr::get($data, 'enabled')
        );
    }
}
