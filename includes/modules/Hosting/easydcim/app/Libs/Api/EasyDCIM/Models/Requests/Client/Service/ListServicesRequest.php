<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BaseAdvancedPaginatedRequest;

/**
 * Request for listing services with pagination and filtering
 */
class ListServicesRequest extends BaseAdvancedPaginatedRequest
{
    public ?string $filter;
    public function __construct(
        ?string $filter = null,
        ?int $perPage = null,
        ?int $page = null,
        ?string $sortBy = null,
        ?string $sortDir = null,
        ?string $searchTerm = null,
        ?string $searchOp = null,
        ?string $searchFields = null
    ) {
        $this->filter = $filter;
        parent::__construct($perPage, $page, $sortBy, $sortDir, $searchTerm, $searchOp, $searchFields);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter(array_merge([
            'filter' => $this->filter,
        ], parent::toArray()), fn($value) => $value !== null);
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['filter'] ?? null,
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
