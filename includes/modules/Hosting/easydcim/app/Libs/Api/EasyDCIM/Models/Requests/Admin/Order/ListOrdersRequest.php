<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BaseAdvancedPaginatedRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BasePaginatedRequest;

/**
 * Request for listing orders with pagination
 */
class ListOrdersRequest extends BaseAdvancedPaginatedRequest
{
    public function __construct(
        public ?int $perPage = null,
        public ?int $page = null,
        public ?string $sortBy = null,
        public ?string $sortDir = null,
        public ?string $searchTerm = null,
        public ?string $searchOp = null,
        public ?string $searchFields = null,
        public ?string $status = null,
    ) {
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
