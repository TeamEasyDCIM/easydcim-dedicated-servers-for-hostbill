<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\System;

/**
 * Request for updating IPMI session activity
 */
class UpdateSessionActivityRequest
{
    public function __construct(
        public string $password,
        public string $port,
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
}
