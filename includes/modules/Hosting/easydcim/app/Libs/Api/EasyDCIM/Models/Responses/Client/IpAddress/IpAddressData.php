<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\IpAddress;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class IpAddressData
{
    public ?int $id;
    public ?string $ipAddress;
    public ?string $description;
    public ?string $type;
    public function __construct(?int $id, ?string $ipAddress, ?string $description = null, ?string $type = null)
    {
        $this->id = $id;
        $this->ipAddress = $ipAddress;
        $this->description = $description;
        $this->type = $type;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'ip_address'),
            Arr::get($data, 'description', null),
            Arr::get($data, 'type', null)
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'ip_address' => $this->ipAddress,
            'description' => $this->description,
            'type' => $this->type,
        ], fn($value) => $value !== null);
    }
}
