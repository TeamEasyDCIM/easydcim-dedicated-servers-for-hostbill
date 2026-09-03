<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests;

/**
 * Base class for simple paginated list requests
 */
abstract class BasePaginatedRequest
{
    public function __construct(
        public ?int $perPage = null,
        public ?int $page = null,
        public ?string $search = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'per_page' => $this->perPage,
            'page' => $this->page,
            'search_term' => $this->search,
        ], fn($value) => $value !== null);
    }
}
