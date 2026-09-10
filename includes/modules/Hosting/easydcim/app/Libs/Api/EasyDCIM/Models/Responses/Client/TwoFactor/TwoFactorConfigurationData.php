<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\TwoFactor;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Two-factor configuration data structure
 */
class TwoFactorConfigurationData
{
    public ?string $qrCode;
    public ?string $secretWord;
    public function __construct(?string $qrCode, ?string $secretWord)
    {
        $this->qrCode = $qrCode;
        $this->secretWord = $secretWord;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'qr_code', ''),
            Arr::get($data, 'secret_word', '')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'qr_code' => $this->qrCode,
            'secret_word' => $this->secretWord,
        ];
    }
}
