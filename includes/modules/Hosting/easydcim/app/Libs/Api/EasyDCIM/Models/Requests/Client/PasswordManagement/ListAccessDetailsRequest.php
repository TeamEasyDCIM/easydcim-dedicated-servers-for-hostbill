<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\PasswordManagement;

class ListAccessDetailsRequest
{
    public ?int $perPage;
    public ?int $page;
    public ?string $sortBy;
    public ?string $sortDir;
    public ?string $searchTerm;
    public ?string $searchOp;
    public ?string $searchFields;
    public function __construct(?int $perPage = null, ?int $page = null, ?string $sortBy = null, ?string $sortDir = null, ?string $searchTerm = null, ?string $searchOp = null, ?string $searchFields = null)
    {
        $this->perPage = $perPage;
        $this->page = $page;
        $this->sortBy = $sortBy;
        $this->sortDir = $sortDir;
        $this->searchTerm = $searchTerm;
        $this->searchOp = $searchOp;
        $this->searchFields = $searchFields;
    }

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
            $data['per_page'] ?? $data['perPage'] ?? null,
            $data['page'] ?? null,
            $data['sort_by'] ?? $data['sortBy'] ?? null,
            $data['sort_dir'] ?? $data['sortDir'] ?? null,
            $data['search_term'] ?? $data['searchTerm'] ?? null,
            $data['search_op'] ?? $data['searchOp'] ?? null,
            $data['search_fields'] ?? $data['searchFields'] ?? null
        );
    }
}
