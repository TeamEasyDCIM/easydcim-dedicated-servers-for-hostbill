<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation;

/**
 * Request for updating an ISO image
 */
class UpdateIsoImageRequest
{
    public ?string $name;
    public ?string $isoUrl;
    public function __construct(?string $name = null, ?string $isoUrl = null)
    {
        $this->name = $name;
        $this->isoUrl = $isoUrl;
    }

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
