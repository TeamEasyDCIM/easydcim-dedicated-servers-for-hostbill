<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BaseAdvancedPaginatedRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BasePaginatedRequest;

/**
 * Request for listing OS installation addons (disk layouts, extras) with pagination
 */
class ListAddonsRequest extends BaseAdvancedPaginatedRequest
{
    public function __construct(
        public ?int $templateId = null,
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
            'template_id' => $this->templateId,
        ], parent::toArray()), fn($value) => $value !== null);
    }
}
