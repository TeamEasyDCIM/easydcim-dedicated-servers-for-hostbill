<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\SshKey;

class CreateSshKeyRequest
{
    public function __construct(
        public string $name,
        public string $sshKey,
        public ?bool $default = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'ssh_key' => $this->sshKey,
            'default' => $this->default,
        ], fn($value) => $value !== null);
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            sshKey: $data['ssh_key'] ?? $data['sshKey'],
            default: $data['default'] ?? null,
        );
    }
}
