<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Ipmi;

class IpmiConsoleRequest
{
    public function __construct(
        public string $password,
        public int $port,
        public string $token,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'password' => $this->password,
            'port' => $this->port,
            'token' => $this->token,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            password: $data['password'],
            port: $data['port'],
            token: $data['token'],
        );
    }
}
