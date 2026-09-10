<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Ipmi;

/**
 * Request for getting IPMI console information
 */
class GetConsoleInformationRequest
{
    public string $password;
    public string $port;
    public string $token;
    public function __construct(string $password, string $port, string $token)
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
}
