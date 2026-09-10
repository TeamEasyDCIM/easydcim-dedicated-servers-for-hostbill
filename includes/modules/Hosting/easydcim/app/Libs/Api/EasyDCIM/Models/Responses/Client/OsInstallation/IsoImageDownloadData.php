<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * ISO Image download status data
 */
class IsoImageDownloadData
{
    public ?string $status;
    public ?string $message;
    public function __construct(?string $status, ?string $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'status', ''),
            Arr::get($data, 'message', '')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
        ];
    }
}
