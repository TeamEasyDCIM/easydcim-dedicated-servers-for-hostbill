<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Ports;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\BasePaginatedRequest;

/**
 * Request for listing service ports with pagination
 */
class ListServicePortsRequest extends BasePaginatedRequest
{
    public ?bool $withTraffic;
    public function __construct(
        ?bool $withTraffic = null,
        ?int $perPage = null,
        ?int $page = null,
        ?string $search = null
    ) {
        $this->withTraffic = $withTraffic;
        parent::__construct($perPage, $page, $search);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter(array_merge([
            'with_traffic' => $this->withTraffic,
        ], parent::toArray()), fn($value) => $value !== null);
    }
}
