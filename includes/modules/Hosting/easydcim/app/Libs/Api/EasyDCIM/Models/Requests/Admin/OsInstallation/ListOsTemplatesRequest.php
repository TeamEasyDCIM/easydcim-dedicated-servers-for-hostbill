<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BaseAdvancedPaginatedRequest;

/**
 * Request for listing OS templates
 */
class ListOsTemplatesRequest extends BaseAdvancedPaginatedRequest
{
    /**
     * @param int|null $perPage Number of items per page
     * @param int|null $page Current page number
     * @param string|null $sortBy Field to sort by
     * @param string|null $sortDir Sort direction (asc/desc)
     * @param string|null $searchTerm Search term
     * @param string|null $searchOp Search operator
     * @param string|null $searchFields Fields to search in
     * @param int|null $withAddons Include addons (1/0)
     */
    public function __construct(
        ?int $perPage = null,
        ?int $page = null,
        ?string $sortBy = null,
        ?string $sortDir = null,
        ?string $searchTerm = null,
        ?string $searchOp = null,
        ?string $searchFields = null,
        public ?int $withAddons = null,
    ) {
        parent::__construct($perPage, $page, $sortBy, $sortDir, $searchTerm, $searchOp, $searchFields);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $params = parent::toArray();
        if ($this->withAddons !== null) {
            $params['with_addons'] = $this->withAddons;
        }
        return $params;
    }
}
