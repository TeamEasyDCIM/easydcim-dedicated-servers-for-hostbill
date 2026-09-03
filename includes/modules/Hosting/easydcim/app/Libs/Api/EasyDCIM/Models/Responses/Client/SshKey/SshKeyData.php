<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\SshKey;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class SshKeyData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $sshKey,
        public ?string $fingerprint,
        public ?bool $default,
        public ?string $createdAt,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id'),
            name: Arr::get($data, 'name'),
            sshKey: Arr::get($data, 'ssh_key'),
            fingerprint: Arr::get($data, 'fingerprint'),
            default: Arr::get($data, 'default'),
            createdAt: Arr::get($data, 'created_at'),
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
