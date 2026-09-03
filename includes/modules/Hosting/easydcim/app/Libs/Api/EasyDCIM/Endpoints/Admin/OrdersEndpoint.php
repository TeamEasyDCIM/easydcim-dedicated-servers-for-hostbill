<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order\AcceptOrderRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order\CreateOrderRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order\GetOrderActionsListRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order\ListOrdersRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order\ListProvisioningLogsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order\QuickCreateOrderRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order\ServiceActionRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order\UpdateOrderRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order\GetOrderActionsListResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order\ListOrdersResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order\OrderResponse;

/**
 * Admin Orders endpoints
 *
 * Manage orders and service lifecycle
 */
class OrdersEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/orders';

    /**
     * List orders with pagination
     *
     * @param ListOrdersRequest|null $request
     * @return ListOrdersResponse
     * @throws EasyDCIMException
     */
    public function list(?ListOrdersRequest $request = null): ListOrdersResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('', $params);
        return ListOrdersResponse::fromArray($response);
    }

    /**
     * Get ALL orders (auto-paginate)
     *
     * @param ListOrdersRequest|null $request
     * @return array Array of all OrderData across all pages
     * @throws EasyDCIMException
     */
    public function listAll(?ListOrdersRequest $request = null): array
    {
        $allOrders = [];
        $currentPage = 1;
        $request = $request ?? new ListOrdersRequest();

        do {
            // Set the current page
            $request = new ListOrdersRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                sortBy: $request->sortBy,
                sortDir: $request->sortDir,
                searchTerm: $request->searchTerm,
                searchOp: $request->searchOp,
                searchFields: $request->searchFields,
                status: $request->status,
            );

            $response = $this->list($request);

            $allOrders = array_merge($allOrders, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allOrders;
    }

    /**
     * Get a specific order
     *
     * @param int|string $id
     * @return OrderResponse
     * @throws EasyDCIMException
     */
    public function show(int|string $id): OrderResponse
    {
        $response = $this->get((string) $id);
        return OrderResponse::fromArray($response);
    }

    /**
     * Create a new order
     *
     * @param CreateOrderRequest $request
     * @return OrderResponse
     */
    public function create(CreateOrderRequest $request): OrderResponse
    {
        $response = $this->post('', $request->toArray());
        return OrderResponse::fromArray($response);
    }

    /**
     * Quick create and activate order
     *
     * Creates and immediately activates an order
     *
     * @param QuickCreateOrderRequest $request
     * @return array
     * @throws EasyDCIMException
     */
    public function quickCreate(QuickCreateOrderRequest $request): array
    {
        return $this->post('quick-create', $request->toArray());
    }

    /**
     * Update an order
     *
     * @param int|string $id
     * @param UpdateOrderRequest $request
     * @return array
     * @throws EasyDCIMException
     */
    public function update(int|string $id, UpdateOrderRequest $request): array
    {
        return $this->put((string) $id, $request->toArray());
    }

    /**
     * Delete an order
     *
     * @param int|string $id
     * @return array
     * @throws EasyDCIMException
     */
    public function destroy(int|string $id): array
    {
        return $this->delete((string) $id);
    }

    /**
     * Accept an order
     *
     * Move order from pending to accepted status
     *
     * @param int|string $id
     * @param AcceptOrderRequest|null $request
     * @return array
     * @throws EasyDCIMException
     */
    public function accept(int|string $id, ?AcceptOrderRequest $request = null): array
    {
        $data = $request?->toArray() ?? [];
        return $this->post($this->buildPath((string) $id, 'accept'), $data);
    }

    /**
     * Activate service for an order
     *
     * Provision and activate the service
     *
     * @param int|string $id
     * @param ServiceActionRequest|null $request
     * @return array
     * @throws EasyDCIMException
     */
    public function activateService(int|string $id, ?ServiceActionRequest $request = null): array
    {
        $data = $request?->toArray() ?? [];
        return $this->post($this->buildPath((string) $id, 'service/activate'), $data);
    }

    /**
     * Suspend service
     *
     * Temporarily suspend the service
     *
     * @param int|string $id
     * @param ServiceActionRequest|null $request
     * @return OrderResponse
     * @throws EasyDCIMException
     */
    public function suspendService(int|string $id, ?ServiceActionRequest $request = null): OrderResponse
    {
        $data = $request?->toArray() ?? [];
        $response = $this->post($this->buildPath((string) $id, 'service/suspend'), $data);
        return OrderResponse::fromArray($response);
    }

    /**
     * Unsuspend service
     *
     * Restore a suspended service
     *
     * @param int|string $id
     * @param ServiceActionRequest|null $request
     * @return OrderResponse
     * @throws EasyDCIMException
     */
    public function unsuspendService(int|string $id, ?ServiceActionRequest $request = null): OrderResponse
    {
        $data = $request?->toArray() ?? [];
        $response = $this->post($this->buildPath((string) $id, 'service/unsuspend'), $data);
        return OrderResponse::fromArray($response);
    }

    /**
     * Terminate service
     *
     * Permanently terminate the service
     *
     * @param int|string $id
     * @param ServiceActionRequest|null $request
     * @return OrderResponse
     * @throws EasyDCIMException
     */
    public function terminateService(int|string $id, ?ServiceActionRequest $request = null): OrderResponse
    {
        $data = $request?->toArray() ?? [];
        $response = $this->post($this->buildPath((string) $id, 'service/terminate'), $data);
        return OrderResponse::fromArray($response);
    }

    /**
     * Get provisioning logs for an order
     *
     * @param int|string $id
     * @param ListProvisioningLogsRequest|null $request
     * @return array
     * @throws EasyDCIMException
     */
    public function listProvisioningLogs(int|string $id, ?ListProvisioningLogsRequest $request = null): array
    {
        $params = $request?->toArray() ?? [];
        return $this->get($this->buildPath((string) $id, 'provisioning-logs'), $params);
    }

    /**
     * Get order actions list
     *
     * Get available actions for orders by type
     *
     * @param GetOrderActionsListRequest|null $request
     * @return GetOrderActionsListResponse
     * @throws EasyDCIMException
     */
    public function getActionsList(?GetOrderActionsListRequest $request = null): GetOrderActionsListResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('actions/list', $params);
        return GetOrderActionsListResponse::fromArray($response);
    }

    /**
     * Get devices in stock based on criteria
     *
     * Check available stock for specific device criteria
     *
     * @param array $criteria Stock criteria (model, location, require_parts, parts)
     * @return array{success: bool, data: array}
     */
    public function getStockByCriteria(array $criteria): array
    {
        return $this->post('stock', ['criteria' => $criteria]);
    }
}
