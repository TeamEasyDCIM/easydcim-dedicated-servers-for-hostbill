<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\ReverseDNS\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ServiceContext;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\IpsHelper;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns\CreateRdnsRecordRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns\ListRdnsRecordsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns\UpdateRdnsRecordRequest;

/**
 * Reverse DNS of one service, as the WHMCS module's ReverseDNS page, its forms
 * and ReverseDNSProvider do it: the records of the EasyDCIM service, the usable
 * addresses the create form lists, the same validators and the same messages.
 * As in WHMCS a CIDR mask is validated, but one record is created - for the
 * address given.
 */
class ReverseDNS
{
    /**
     * @var EasyDCIMClient
     */
    protected $api;

    /**
     * @var ServiceContext
     */
    protected $context;

    /**
     * The service's addresses as EasyDCIM lists them (addresses and subnets).
     *
     * @var string[]|null
     */
    protected $rawIpAddresses = null;

    public function __construct($api, ServiceContext $context)
    {
        $this->api = $api;
        $this->context = $context;
    }

    /**
     * The "Available IP Addresses" of the create form (CreateForm::getIPAddresses).
     *
     * @return string[]
     */
    public function getIPAddresses(): array
    {
        return IpsHelper::listUsableIPsFromArray($this->getRawIpAddresses());
    }

    /**
     * The client API's view of the service, as WHMCS reads it; any failure
     * leaves the list empty, which also switches the pool check off.
     */
    protected function getRawIpAddresses(): array
    {
        if ($this->rawIpAddresses !== null) {
            return $this->rawIpAddresses;
        }

        $this->rawIpAddresses = [];

        try {
            $serviceId = $this->context->serviceId();
            if ($serviceId === null) {
                return $this->rawIpAddresses;
            }

            $response = $this->api->client()->services()->show($serviceId);
            if (!$response->success || $response->data === null || $response->data->related === null) {
                return $this->rawIpAddresses;
            }

            $ipAddresses = array_map('trim', (array) $response->data->related->ipAddresses);
            $this->rawIpAddresses = array_values(array_filter($ipAddresses, function ($ip) {
                return !empty($ip);
            }));
        } catch (\Exception $e) {
        }

        return $this->rawIpAddresses;
    }

    public function getDNS()
    {
        $data = [];

        foreach ($this->getAllrDNSRecords() as $value)
        {
            $data[] = [
                'id'        => $value->id,
                'ipAddress' => $value->ip,
                'hostname'  => $value->from,
                'created'   => $value->createdAt,
            ];
        }

        return $data;
    }

    protected function getAllrDNSRecords(): array
    {
        try {
            return $this->api->client()->dnsManagement()->listAllRdnsRecords(
                $this->context->requireServiceId(),
                new ListRdnsRecordsRequest()
            );
        } catch (\Exception $exc) {
            return [];
        }
    }

    public function create($data)
    {
        $data = (array) $data;

        $errors = $this->validateCreate($data);
        if (!empty($errors)) {
            $this->fail(['fields' => $errors]);
        }

        try {
            $result = $this->api->client()->dnsManagement()->createRdnsRecord(
                $this->context->requireServiceId(),
                new CreateRdnsRecordRequest(
                    (string) $data['reverseDNSIpAddress'],
                    (string) $data['reverseDNSHostname'],
                    (int) ($data['reverseDNSTTL'] ?? 3600)
                )
            );

            if ($result->success === false) {
                throw new \Exception($result->message ?? 'Record cannot be added');
            }
        } catch (\Exception $exc) {
            $this->fail(['error' => 'Failed to create DNS record: ' . $exc->getMessage()]);
        }

        self::jsonEncode(['message' => 'DNS record created successfully']);
    }

    public function update($data)
    {
        $data = (array) $data;
        $hostname = $data['hostname'] ?? '';

        $error = $this->hostnameError($hostname);
        if ($error !== '') {
            $this->fail(['fields' => ['hostname' => $error]]);
        }

        try {
            $recordId = $data['recordId'] ?? '';
            if (empty($recordId) || empty($hostname)) {
                throw new \Exception('Record ID and hostname are required');
            }

            $result = $this->api->client()->dnsManagement()->updateRdnsRecord(
                $this->context->requireServiceId(),
                (int) $recordId,
                new UpdateRdnsRecordRequest((string) $hostname)
            );

            if ($result->success === false) {
                throw new \Exception($result->message ?? 'Record cannot be updated');
            }
        } catch (\Exception $exc) {
            $this->fail(['error' => 'Failed to update DNS record: ' . $exc->getMessage()]);
        }

        self::jsonEncode(['message' => 'DNS record updated successfully']);
    }

    public function delete($data)
    {
        $data = (array) $data;

        try {
            $result = $this->api->client()->dnsManagement()->deleteRdnsRecord(
                $this->context->requireServiceId(),
                (int) ($data['recordId'] ?? 0)
            );

            if ($result->success === false) {
                throw new \Exception($result->message ?? 'Record cannot be deleted');
            }
        } catch (\Exception $exc) {
            $this->fail(['error' => 'Failed to delete DNS record: ' . $exc->getMessage()]);
        }

        self::jsonEncode(['message' => 'DNS record deleted successfully']);
    }

    /**
     * The selected records one by one; like WHMCS it stops at the first failure.
     */
    public function massDelete($ids)
    {
        try {
            $serviceId = $this->context->requireServiceId();
            $ids = array_filter((array) $ids, function ($id) {
                return $id !== '' && $id !== null;
            });

            if (empty($ids)) {
                throw new \Exception('No records specified for deletion');
            }

            foreach ($ids as $id) {
                $result = $this->api->client()->dnsManagement()->deleteRdnsRecord($serviceId, (int) $id);

                if ($result->success === false) {
                    throw new \Exception($result->message ?? 'Record cannot be deleted');
                }
            }
        } catch (\Exception $exc) {
            $this->fail(['error' => 'Failed to delete DNS record: ' . $exc->getMessage()]);
        }

        self::jsonEncode(['message' => 'DNS record has been deleted successfully']);
    }

    /**
     * The WHMCS CreateForm validators, first failing message per field:
     * IpAddressValidator and IpInPoolValidator, MaskValidator, HostnameValidator.
     */
    protected function validateCreate(array $data): array
    {
        $errors = [];
        $ipAddress = $data['reverseDNSIpAddress'] ?? '';
        $mask = $data['reverseDNSMask'] ?? '';

        if (empty($ipAddress) || filter_var($ipAddress, FILTER_VALIDATE_IP) === false) {
            $errors['reverseDNSIpAddress'] = 'Please provide a valid IP address';
        } elseif (empty($mask) && !empty($this->getRawIpAddresses()) && !IpsHelper::isIpInPool((string) $ipAddress, $this->getRawIpAddresses())) {
            $errors['reverseDNSIpAddress'] = 'The IP address is not in the available IP pool for this service';
        }

        if ($mask !== '' && $mask !== null) {
            if (!empty($ipAddress) && filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $errors['reverseDNSMask'] = 'You cannot provide mask for IPv6';
            } else {
                $integerPart = filter_var($mask, FILTER_SANITIZE_NUMBER_INT);
                if (filter_var($integerPart, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 32]]) === false) {
                    $errors['reverseDNSMask'] = 'Please provide a valid mask in the form of a shortened CIDR mask notation (0-32)';
                }
            }
        }

        $error = $this->hostnameError($data['reverseDNSHostname'] ?? '');
        if ($error !== '') {
            $errors['reverseDNSHostname'] = $error;
        }

        return $errors;
    }

    // Forms/Validators/HostnameValidator
    protected function hostnameError($value): string
    {
        if (empty($value) || !preg_match('/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i', (string) $value)) {
            return 'Please provide a valid hostname';
        }

        return '';
    }

    protected function fail(array $data): void
    {
        header('HTTP/1.1 400 Bad Request');
        self::jsonEncode($data);
    }

    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data'=>$data
        ]));
        die;
    }
}
