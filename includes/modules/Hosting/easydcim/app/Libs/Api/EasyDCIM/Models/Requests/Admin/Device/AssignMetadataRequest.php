<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device;

/**
 * Request for assigning metadata to a device
 */
class AssignMetadataRequest
{
    public string $slug;
    public string $value;
    public function __construct(string $slug, string $value)
    {
        $this->slug = $slug;
        $this->value = $value;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'value' => $this->value,
        ];
    }
}
