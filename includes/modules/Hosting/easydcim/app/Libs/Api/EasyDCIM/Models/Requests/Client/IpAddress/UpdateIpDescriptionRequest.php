<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\IpAddress;

class UpdateIpDescriptionRequest
{
    public function __construct(
        public string $description,
        public string $ipAddress,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'ip_address' => $this->ipAddress,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            description: $data['description'],
            ipAddress: $data['ip_address'] ?? $data['ipAddress'],
        );
    }
}
