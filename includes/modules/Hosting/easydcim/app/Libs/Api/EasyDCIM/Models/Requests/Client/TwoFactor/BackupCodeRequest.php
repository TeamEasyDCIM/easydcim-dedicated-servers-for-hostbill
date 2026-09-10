<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\TwoFactor;

/**
 * Request for generating backup code
 */
class BackupCodeRequest
{
    public string $code;
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['code']
        );
    }
}
