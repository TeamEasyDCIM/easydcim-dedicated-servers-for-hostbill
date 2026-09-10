<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\IpAddress;

class UpdateIpDescriptionRequest
{
    public string $description;
    public string $ipAddress;
    public function __construct(string $description, string $ipAddress)
    {
        $this->description = $description;
        $this->ipAddress = $ipAddress;
    }

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
            $data['description'],
            $data['ip_address'] ?? $data['ipAddress']
        );
    }
}
