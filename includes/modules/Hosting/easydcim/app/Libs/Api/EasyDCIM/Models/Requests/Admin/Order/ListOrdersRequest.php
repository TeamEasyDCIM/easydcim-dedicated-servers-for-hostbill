<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BaseAdvancedPaginatedRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BasePaginatedRequest;

/**
 * Request for listing orders with pagination
 */
class ListOrdersRequest extends BaseAdvancedPaginatedRequest
{
    public ?int $perPage;
    public ?int $page;
    public ?string $sortBy;
    public ?string $sortDir;
    public ?string $searchTerm;
    public ?string $searchOp;
    public ?string $searchFields;
    public ?string $status;
    public function __construct(
        ?int $perPage = null,
        ?int $page = null,
        ?string $sortBy = null,
        ?string $sortDir = null,
        ?string $searchTerm = null,
        ?string $searchOp = null,
        ?string $searchFields = null,
        ?string $status = null
    ) {
        $this->perPage = $perPage;
        $this->page = $page;
        $this->sortBy = $sortBy;
        $this->sortDir = $sortDir;
        $this->searchTerm = $searchTerm;
        $this->searchOp = $searchOp;
        $this->searchFields = $searchFields;
        $this->status = $status;
        parent::__construct($perPage, $page, $sortBy, $sortDir, $searchTerm, $searchOp, $searchFields);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter(array_merge(parent::toArray(), [
            'status' => $this->status,
        ]), fn($value) => $value !== null);
    }
}
