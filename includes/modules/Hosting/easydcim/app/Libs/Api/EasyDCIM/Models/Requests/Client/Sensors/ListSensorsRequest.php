<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Sensors;

class ListSensorsRequest
{
    public function __construct(
        public ?int $perPage = null,
        public ?int $page = null,
        public ?string $sortBy = null,
        public ?string $sortDir = null,
        public ?string $searchTerm = null,
        public ?string $searchOp = null,
        public ?string $searchFields = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'per_page' => $this->perPage,
            'page' => $this->page,
            'sort_by' => $this->sortBy,
            'sort_dir' => $this->sortDir,
            'search_term' => $this->searchTerm,
            'search_op' => $this->searchOp,
            'search_fields' => $this->searchFields,
        ], fn($value) => $value !== null);
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            perPage: $data['per_page'] ?? $data['perPage'] ?? null,
            page: $data['page'] ?? null,
            sortBy: $data['sort_by'] ?? $data['sortBy'] ?? null,
            sortDir: $data['sort_dir'] ?? $data['sortDir'] ?? null,
            searchTerm: $data['search_term'] ?? $data['searchTerm'] ?? null,
            searchOp: $data['search_op'] ?? $data['searchOp'] ?? null,
            searchFields: $data['search_fields'] ?? $data['searchFields'] ?? null,
        );
    }
}
