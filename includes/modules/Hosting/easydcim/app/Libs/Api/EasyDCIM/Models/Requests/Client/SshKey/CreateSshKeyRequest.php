<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\SshKey;

class CreateSshKeyRequest
{
    public string $name;
    public string $sshKey;
    public ?bool $default;
    public function __construct(string $name, string $sshKey, ?bool $default = null)
    {
        $this->name = $name;
        $this->sshKey = $sshKey;
        $this->default = $default;
    }

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
            $data['name'],
            $data['ssh_key'] ?? $data['sshKey'],
            $data['default'] ?? null
        );
    }
}
