<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Client ISO Image data
 */
class ClientIsoImageData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $isoUrl,
        public ?int $status,
        public ?IsoImageDownloadData $download,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {}

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
            id: Arr::get($data, 'id', 0),
            name: Arr::get($data, 'name', ''),
            isoUrl: Arr::get($data, 'iso_url', ''),
            status: Arr::get($data, 'status', 0),
            download: IsoImageDownloadData::fromArray($download),
            createdAt: Arr::get($data, 'created_at', ''),
            updatedAt: Arr::get($data, 'updated_at', ''),
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
