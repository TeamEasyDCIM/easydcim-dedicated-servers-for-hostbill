<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Graph\ExportGraphRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Graph\ExportGraphResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Graph\GraphData;

/**
 * Client Graphs endpoints
 */
class GraphsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client/graphs';
    protected bool $isClientEndpoint = true;

    /**
     * Export graph data for a service
     *
     * @param int|string $serviceId EasyDCIM Service ID
     * @param ExportGraphRequest $request Export request with graph type, target, dates, etc.
     * @return GraphData Graph data with datasets, labels, and units
     */
    public function export($serviceId, ExportGraphRequest $request): GraphData
    {
        $path = $this->buildPath((string) $serviceId, 'export');

        $response = $this->post($path, $request->toArray());

        // Parse response into typed models
        $graphResponse = ExportGraphResponse::fromArray($response);

        // Return the data object (or empty GraphData if null)
        return $graphResponse->data ?? new GraphData();
    }
}
