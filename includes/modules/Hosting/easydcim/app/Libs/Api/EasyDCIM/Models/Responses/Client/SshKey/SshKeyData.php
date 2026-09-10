<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\SshKey;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class SshKeyData
{
    public ?int $id;
    public ?string $name;
    public ?string $sshKey;
    public ?string $fingerprint;
    public ?bool $default;
    public ?string $createdAt;
    public function __construct(?int $id, ?string $name, ?string $sshKey, ?string $fingerprint, ?bool $default, ?string $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->sshKey = $sshKey;
        $this->fingerprint = $fingerprint;
        $this->default = $default;
        $this->createdAt = $createdAt;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'name'),
            Arr::get($data, 'ssh_key'),
            Arr::get($data, 'fingerprint'),
            Arr::get($data, 'default'),
            Arr::get($data, 'created_at')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ssh_key' => $this->sshKey,
            'fingerprint' => $this->fingerprint,
            'default' => $this->default,
            'created_at' => $this->createdAt,
        ];
    }
}
