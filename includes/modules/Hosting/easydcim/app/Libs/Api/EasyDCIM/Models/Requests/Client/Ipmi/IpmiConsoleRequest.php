<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Ipmi;

class IpmiConsoleRequest
{
    public string $password;
    public int $port;
    public string $token;
    public function __construct(string $password, int $port, string $token)
    {
        $this->password = $password;
        $this->port = $port;
        $this->token = $token;
    }

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
            $data['password'],
            $data['port'],
            $data['token']
        );
    }
}
