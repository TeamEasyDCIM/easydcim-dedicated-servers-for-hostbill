<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class PaginationMeta
{
    public ?int $currentPage;
    public ?int $from;
    public ?int $lastPage;
    public ?array $links;
    public ?string $path;
    public ?int $perPage;
    public ?int $to;
    public ?int $total;
    public ?string $sortBy;
    public ?string $sortDir;
    /**
     * @param array<array{url: string|null, label: string, page: int|null, active: bool}> $links
     */
    public function __construct(?int $currentPage, ?int $from, ?int $lastPage, ?array $links, ?string $path, ?int $perPage, ?int $to, ?int $total, ?string $sortBy = null, ?string $sortDir = null)
    {
        $this->currentPage = $currentPage;
        $this->from = $from;
        $this->lastPage = $lastPage;
        $this->links = $links;
        $this->path = $path;
        $this->perPage = $perPage;
        $this->to = $to;
        $this->total = $total;
        $this->sortBy = $sortBy;
        $this->sortDir = $sortDir;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'current_page', 1),
            Arr::get($data, 'from'),
            Arr::get($data, 'last_page', 1),
            Arr::get($data, 'links', []),
            Arr::get($data, 'path', ''),
            Arr::get($data, 'per_page', 15),
            Arr::get($data, 'to'),
            Arr::get($data, 'total', 0),
            Arr::get($data, 'sort_by'),
            Arr::get($data, 'sort_dir')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'current_page' => $this->currentPage,
            'from' => $this->from,
            'last_page' => $this->lastPage,
            'links' => $this->links,
            'path' => $this->path,
            'per_page' => $this->perPage,
            'to' => $this->to,
            'total' => $this->total,
            'sort_by' => $this->sortBy,
            'sort_dir' => $this->sortDir,
        ], fn($value) => $value !== null);
    }
}
