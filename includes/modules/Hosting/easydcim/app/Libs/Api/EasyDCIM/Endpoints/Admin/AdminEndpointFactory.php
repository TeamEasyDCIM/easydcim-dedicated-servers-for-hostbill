<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts\ClientInterface;

/**
 * Factory for Admin endpoints
 * 
 * Provides fluent access to all admin API endpoints:
 * 
 * ```php
 * $client->admin()->system()->getSystemConfig();
 * $client->admin()->locations()->list();
 * $client->admin()->users()->show(123);
 * $client->admin()->orders()->create([...]);
 * ```
 */
class AdminEndpointFactory
{
    private ClientInterface $client;

    /**
     * Cached endpoint instances
     * @var array<string, object>
     */
    private array $endpoints = [];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get System endpoint
     */
    public function system(): SystemEndpoint
    {
        return $this->endpoints['system'] ??= new SystemEndpoint($this->client);
    }

    /**
     * Get Locations endpoint
     */
    public function locations(): LocationsEndpoint
    {
        return $this->endpoints['locations'] ??= new LocationsEndpoint($this->client);
    }

    /**
     * Get Graphs endpoint
     */
    public function graphs(): GraphsEndpoint
    {
        return $this->endpoints['graphs'] ??= new GraphsEndpoint($this->client);
    }

    /**
     * Get Racks endpoint
     */
    public function racks(): RacksEndpoint
    {
        return $this->endpoints['racks'] ??= new RacksEndpoint($this->client);
    }

    /**
     * Get Users endpoint
     */
    public function users(): UsersEndpoint
    {
        return $this->endpoints['users'] ??= new UsersEndpoint($this->client);
    }

    /**
     * Get Orders endpoint
     */
    public function orders(): OrdersEndpoint
    {
        return $this->endpoints['orders'] ??= new OrdersEndpoint($this->client);
    }

    /**
     * Get Service Access Levels endpoint
     */
    public function accessLevels(): ServiceAccessLevelsEndpoint
    {
        return $this->endpoints['accessLevels'] ??= new ServiceAccessLevelsEndpoint($this->client);
    }

    /**
     * Get Fields endpoint
     */
    public function fields(): FieldsEndpoint
    {
        return $this->endpoints['fields'] ??= new FieldsEndpoint($this->client);
    }

    /**
     * Get Devices endpoint
     */
    public function devices(): DevicesEndpoint
    {
        return $this->endpoints['devices'] ??= new DevicesEndpoint($this->client);
    }

    /**
     * Get Permissions endpoint
     */
    public function permissions(): PermissionsEndpoint
    {
        return $this->endpoints['permissions'] ??= new PermissionsEndpoint($this->client);
    }

    /**
     * Get Groups endpoint
     */
    public function groups(): GroupsEndpoint
    {
        return $this->endpoints['groups'] ??= new GroupsEndpoint($this->client);
    }

    // Placeholder methods for remaining endpoints (to be implemented)
    
    /**
     * Get Floors endpoint
     * @return mixed
     */
    public function floors()
    {
        throw new \BadMethodCallException('Floors endpoint not yet implemented');
    }

    /**
     * Get Item Models endpoint
     * @return ItemModelsEndpoint
     */
    public function itemModels(): ItemModelsEndpoint
    {
        return $this->endpoints['itemModels'] ??= new ItemModelsEndpoint($this->client);
    }

    /**
     * Get Ports endpoint
     * @return PortsEndpoint
     */
    public function ports(): PortsEndpoint
    {
        return $this->endpoints['ports'] ??= new PortsEndpoint($this->client);
    }

    /**
     * Get Usage Collector endpoint
     * @return UsageCollectorEndpoint
     */
    public function usageCollector(): UsageCollectorEndpoint
    {
        return $this->endpoints['usageCollector'] ??= new UsageCollectorEndpoint($this->client);
    }

    /**
     * Get Power Ports endpoint
     * @return mixed
     */
    public function powerPorts()
    {
        throw new \BadMethodCallException('PowerPorts endpoint not yet implemented');
    }

    /**
     * Get Device Bays endpoint
     * @return mixed
     */
    public function deviceBays()
    {
        throw new \BadMethodCallException('DeviceBays endpoint not yet implemented');
    }

    /**
     * Get Item Types endpoint
     * @return ItemTypesEndpoint
     */
    public function itemTypes(): ItemTypesEndpoint
    {
        return $this->endpoints['itemTypes'] ??= new ItemTypesEndpoint($this->client);
    }


    /**
     * Get Items endpoint
     * @return mixed
     */
    public function items()
    {
        throw new \BadMethodCallException('Items endpoint not yet implemented');
    }

    /**
     * Get Item Type Fields endpoint
     * @return mixed
     */
    public function itemTypeFields()
    {
        throw new \BadMethodCallException('ItemTypeFields endpoint not yet implemented');
    }

    /**
     * Get Sensors endpoint
     * @return mixed
     */
    public function sensors()
    {
        throw new \BadMethodCallException('Sensors endpoint not yet implemented');
    }

    /**
     * Get Remote Agents endpoint
     * @return mixed
     */
    public function remoteAgents()
    {
        throw new \BadMethodCallException('RemoteAgents endpoint not yet implemented');
    }

    /**
     * Get OS Installation endpoint
     * @return OsInstallationEndpoint
     */
    public function osInstallation(): OsInstallationEndpoint
    {
        return $this->endpoints['osInstallation'] ??= new OsInstallationEndpoint($this->client);
    }

    /**
     * Get IPMI endpoint
     * @return IpmiEndpoint
     */
    public function ipmi(): IpmiEndpoint
    {
        return $this->endpoints['ipmi'] ??= new IpmiEndpoint($this->client);
    }

    /**
     * Get IP Address Management endpoint
     * @return mixed
     */
    public function ipAddressManagement()
    {
        throw new \BadMethodCallException('IpAddressManagement endpoint not yet implemented');
    }

    /**
     * Get DNS Management endpoint
     * @return mixed
     */
    public function dnsManagement()
    {
        throw new \BadMethodCallException('DnsManagement endpoint not yet implemented');
    }

    /**
     * Get Password Manager endpoint
     * @return mixed
     */
    public function passwordManager()
    {
        throw new \BadMethodCallException('PasswordManager endpoint not yet implemented');
    }

    /**
     * Get Tags endpoint
     * @return mixed
     */
    public function tags()
    {
        throw new \BadMethodCallException('Tags endpoint not yet implemented');
    }
}
