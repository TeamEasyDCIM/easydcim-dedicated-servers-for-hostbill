<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Client ISO Image data
 */
class ClientIsoImageData
{
    public ?int $id;
    public ?string $name;
    public ?string $isoUrl;
    public ?int $status;
    public ?IsoImageDownloadData $download;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id, ?string $name, ?string $isoUrl, ?int $status, ?IsoImageDownloadData $download, ?string $createdAt, ?string $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isoUrl = $isoUrl;
        $this->status = $status;
        $this->download = $download;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $download = Arr::get($data, 'download', []);
        if (!is_array($download)) {
            $download = [];
        }

        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'name', ''),
            Arr::get($data, 'iso_url', ''),
            Arr::get($data, 'status', 0),
            IsoImageDownloadData::fromArray($download),
            Arr::get($data, 'created_at', ''),
            Arr::get($data, 'updated_at', '')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'iso_url' => $this->isoUrl,
            'status' => $this->status,
            'download' => $this->download->toArray(),
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
