<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Sensors\ListSensorsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Sensors\ListSensorsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Sensors\SensorData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Sensors\ShowSensorResponse;

/**
 * Client Sensors endpoints
 */
class SensorsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client/services';
    protected bool $isClientEndpoint = true;

    /**
     * List sensors for a service
     *
     * @param int|string $serviceId
     * @param ListSensorsRequest|null $request
     * @return ListSensorsResponse
     * @throws EasyDCIMException
     */
    public function list($serviceId, ?ListSensorsRequest $request = null): ListSensorsResponse
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->get($this->buildPath((string) $serviceId, 'sensors'), $params);
        return ListSensorsResponse::fromArray($response);
    }

    /**
     * Get details of a specific sensor
     *
     * @param int|string $serviceId Service ID
     * @param int|string $sensorId Sensor ID
     * @return ShowSensorResponse
     * @throws EasyDCIMException
     */
    public function show($serviceId, $sensorId): ShowSensorResponse
    {
        $response = $this->get($this->buildPath((string) $serviceId, 'sensors', (string) $sensorId));
        return ShowSensorResponse::fromArray($response);
    }

    /**
     * Get ALL sensors for a service (auto-paginate)
     *
     * @param int|string $serviceId
     * @param ListSensorsRequest|null $request
     * @return array<SensorData> Array of all sensors across all pages
     * @throws EasyDCIMException
     */
    public function listAll($serviceId, ?ListSensorsRequest $request = null): array
    {
        $allSensors = [];
        $currentPage = 1;
        $request = $request ?? new ListSensorsRequest();

        do {
            // Set the current page
            $request = new ListSensorsRequest(
                $request->perPage ?? 100,
                $currentPage,
                $request->sortBy,
                $request->sortDir,
                $request->searchTerm,
                $request->searchOp,
                $request->searchFields
            );

            $response = $this->list($serviceId, $request);
            $allSensors = array_merge($allSensors, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allSensors;
    }
}
