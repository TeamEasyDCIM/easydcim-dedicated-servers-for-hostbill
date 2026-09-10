<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BaseAdvancedPaginatedRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BasePaginatedRequest;

/**
 * Request for listing OS templates with pagination
 */
class ListTemplatesRequest extends BaseAdvancedPaginatedRequest
{
    public ?bool $withAddons;
    public ?int $perPage;
    public ?int $page;
    public ?string $sortBy;
    public ?string $sortDir;
    public ?string $searchTerm;
    public ?string $searchOp;
    public ?string $searchFields;
    public function __construct(
        ?bool $withAddons = null,
        ?int $perPage = null,
        ?int $page = null,
        ?string $sortBy = null,
        ?string $sortDir = null,
        ?string $searchTerm = null,
        ?string $searchOp = null,
        ?string $searchFields = null
    ) {
        $this->withAddons = $withAddons;
        $this->perPage = $perPage;
        $this->page = $page;
        $this->sortBy = $sortBy;
        $this->sortDir = $sortDir;
        $this->searchTerm = $searchTerm;
        $this->searchOp = $searchOp;
        $this->searchFields = $searchFields;
        parent::__construct($perPage, $page, $sortBy, $sortDir, $searchTerm, $searchOp, $searchFields);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter(array_merge([
            'with_addons' => $this->withAddons,
        ], parent::toArray()), fn($value) => $value !== null);
    }
}
