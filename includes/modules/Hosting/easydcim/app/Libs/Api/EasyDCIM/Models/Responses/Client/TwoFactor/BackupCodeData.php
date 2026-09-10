<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\TwoFactor;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Backup code data structure
 */
class BackupCodeData
{
    public ?string $backupCode;
    public function __construct(?string $backupCode)
    {
        $this->backupCode = $backupCode;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'backup_code', '')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'backup_code' => $this->backupCode,
        ];
    }
}
