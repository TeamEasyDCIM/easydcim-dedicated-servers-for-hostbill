<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BaseAdvancedPaginatedRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BasePaginatedRequest;

/**
 * Request for listing OS templates with pagination
 */
class ListTemplatesRequest extends BaseAdvancedPaginatedRequest
{
    public function __construct(
        public ?bool $withAddons = null,
        public ?int $perPage = null,
        public ?int $page = null,
        public ?string $sortBy = null,
        public ?string $sortDir = null,
        public ?string $searchTerm = null,
        public ?string $searchOp = null,
        public ?string $searchFields = null,
    ) {
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
