<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation;

/**
 * Request for updating an ISO image
 */
class UpdateIsoImageRequest
{
    public function __construct(
        public ?string $name = null,
        public ?string $isoUrl = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'iso_url' => $this->isoUrl,
        ], fn($value) => $value !== null);
    }
}
