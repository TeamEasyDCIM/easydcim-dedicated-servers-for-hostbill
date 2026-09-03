<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests;

/**
 * Base class for advanced paginated list requests with sorting and search
 */
abstract class BaseAdvancedPaginatedRequest
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
}
