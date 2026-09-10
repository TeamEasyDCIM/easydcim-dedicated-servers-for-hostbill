<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BaseAdvancedPaginatedRequest;

/**
 * Request for listing OS addons
 */
class ListOsAddonsRequest extends BaseAdvancedPaginatedRequest
{
    public ?int $templateId;
    /**
     * @param int|null $perPage Number of items per page
     * @param int|null $page Current page number
     * @param string|null $sortBy Field to sort by
     * @param string|null $sortDir Sort direction (asc/desc)
     * @param string|null $searchTerm Search term
     * @param string|null $searchOp Search operator
     * @param string|null $searchFields Fields to search in
     * @param int|null $templateId Filter by template ID
     */
    public function __construct(
        ?int $perPage = null,
        ?int $page = null,
        ?string $sortBy = null,
        ?string $sortDir = null,
        ?string $searchTerm = null,
        ?string $searchOp = null,
        ?string $searchFields = null,
        ?int $templateId = null
    ) {
        $this->templateId = $templateId;
        parent::__construct($perPage, $page, $sortBy, $sortDir, $searchTerm, $searchOp, $searchFields);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $params = parent::toArray();
        if ($this->templateId !== null) {
            $params['template_id'] = $this->templateId;
        }
        return $params;
    }
}
