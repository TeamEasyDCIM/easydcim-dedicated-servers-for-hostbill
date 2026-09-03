<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts\ClientInterface;

/**
 * Factory for Client endpoints
 * 
 * Provides fluent access to all client API endpoints:
 * 
 * ```php
 * $client->client()->services()->list();
 * $client->client()->users()->me();
 * 
 * // With impersonation
 * $client->setImpersonateUser('user@example.com');
 * $client->client()->services()->list();
 * ```
 */
class ClientEndpointFactory
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
     * Get Users endpoint
     */
    public function users(): UsersEndpoint
    {
        return $this->endpoints['users'] ??= new UsersEndpoint($this->client);
    }

    /**
     * Get Services endpoint
     */
    public function services(): ServicesEndpoint
    {
        return $this->endpoints['services'] ??= new ServicesEndpoint($this->client);
    }

    /**
     * Get System endpoint
     */
    public function system(): SystemEndpoint
    {
        return $this->endpoints['system'] ??= new SystemEndpoint($this->client);
    }

    /**
     * Get SSH Keys endpoint
     */
    public function sshKeys(): SshKeysEndpoint
    {
        return $this->endpoints['sshKeys'] ??= new SshKeysEndpoint($this->client);
    }

    /**
     * Get Parts endpoint
     */
    public function parts(): PartsEndpoint
    {
        return $this->endpoints['parts'] ??= new PartsEndpoint($this->client);
    }

    /**
     * Get Power Ports endpoint
     */
    public function powerPorts(): PowerPortsEndpoint
    {
        return $this->endpoints['powerPorts'] ??= new PowerPortsEndpoint($this->client);
    }

    /**
     * Get Ports endpoint
     */
    public function ports(): PortsEndpoint
    {
        return $this->endpoints['ports'] ??= new PortsEndpoint($this->client);
    }

    /**
     * Get Graphs endpoint
     */
    public function graphs(): GraphsEndpoint
    {
        return $this->endpoints['graphs'] ??= new GraphsEndpoint($this->client);
    }

    /**
     * Get OS Installation endpoint
     */
    public function osInstallation(): OsInstallationEndpoint
    {
        return $this->endpoints['osInstallation'] ??= new OsInstallationEndpoint($this->client);
    }

    /**
     * Get IPMI endpoint
     */
    public function ipmi(): IpmiEndpoint
    {
        return $this->endpoints['ipmi'] ??= new IpmiEndpoint($this->client);
    }

    /**
     * Get IP Address Management endpoint
     */
    public function ipAddressManagement(): IpAddressManagementEndpoint
    {
        return $this->endpoints['ipAddressManagement'] ??= new IpAddressManagementEndpoint($this->client);
    }

    /**
     * Get DNS Management endpoint
     */
    public function dnsManagement(): DnsManagementEndpoint
    {
        return $this->endpoints['dnsManagement'] ??= new DnsManagementEndpoint($this->client);
    }

    /**
     * Get Two-Factor Authentication endpoint
     */
    public function twoFactorAuth(): TwoFactorAuthEndpoint
    {
        return $this->endpoints['twoFactorAuth'] ??= new TwoFactorAuthEndpoint($this->client);
    }

    /**
     * Get Password Management endpoint
     */
    public function passwordManagement(): PasswordManagementEndpoint
    {
        return $this->endpoints['passwordManagement'] ??= new PasswordManagementEndpoint($this->client);
    }

    /**
     * Get Sensors endpoint
     */
    public function sensors(): SensorsEndpoint
    {
        return $this->endpoints['sensors'] ??= new SensorsEndpoint($this->client);
    }
}
