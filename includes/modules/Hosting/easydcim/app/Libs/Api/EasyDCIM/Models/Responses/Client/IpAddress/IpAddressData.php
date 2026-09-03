<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\IpAddress;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class IpAddressData
{
    public function __construct(
        public ?int $id,
        public ?string $ipAddress,
        public ?string $description = null,
        public ?string $type = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id'),
            ipAddress: Arr::get($data, 'ip_address'),
            description: Arr::get($data, 'description', null),
            type: Arr::get($data, 'type', null),
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
