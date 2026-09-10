<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\ReverseDNS\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ServiceContext;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns\CreateRdnsRecordRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns\ListRdnsRecordsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns\UpdateRdnsRecordRequest;

class ReverseDNS
{
    /**
     * @var EasyDCIMClient
     */
    protected $api;

    /**
     * Reverse DNS has no admin endpoint in API v3 - every call is
     * service-scoped and made on behalf of the account's owner.
     *
     * @var ServiceContext
     */
    protected $context;

    public function __construct($api, ServiceContext $context)
    {
        $this->api = $api;
        $this->context = $context;
    }

    public function getIPAddresses(): array
    {
        $data = [];

        $deviceId = $this->context->deviceId();

        if ($deviceId === null)
        {
            return $data;
        }

        $device = $this->api->admin()->devices()->show($deviceId)->data;

        if (!empty($device === null ? null : $device->ipList))
        {
            $ipAddresses = $device->ipList;
        }
        else
        {
            $metadata = (array) (($device === null ? null : $device->metadata) ?? []);
            $additional = explode(',', (string) ($metadata['Additional IP Addresses'] ?? ''));
            $primary = [$metadata['IP Address'] ?? ''];
            $ipAddresses = array_filter(array_merge($primary, $additional));
        }

        foreach ($ipAddresses as $value)
        {
            $data[] = [
                'ipAddresses'=>$value
            ];
        }

        return $data;
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

    /**
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Dns\RdnsRecordData>
     */
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
        try
        {
            $serviceId = $this->context->requireServiceId();
            $hostname = $data['reverseDNSHostname'];
            $ttl = (int) ($data['reverseDNSTTL'] ?: 3600);

            if (empty($data['reverseDNSMask']))
            {
                $result = $this->api->client()->dnsManagement()->createRdnsRecord(
                    $serviceId,
                    new CreateRdnsRecordRequest($data['reverseDNSIpAddress'], $hostname, $ttl)
                );

                if ($result->success === false)
                {
                    header('HTTP/1.1 400 Bad Request');
                    self::jsonEncode([
                        'error'=>$result->message != '' ? $result->message : "Record cannot be added"
                    ]);
                }

                self::jsonEncode([
                    'message'=>'Record added successfully'
                ]);
            }

            $mask = filter_var($data['reverseDNSMask'], FILTER_SANITIZE_NUMBER_INT);
            $pool = $this->createIpv4Pool($data['reverseDNSIpAddress'], $mask);
            $createdRecords = [];

            foreach ($pool as $value)
            {
                $result = $this->api->client()->dnsManagement()->createRdnsRecord(
                    $serviceId,
                    new CreateRdnsRecordRequest($value, $hostname, $ttl)
                );

                if ($result->success === false)
                {
                    // Roll the partial pool back so a failed batch leaves nothing behind.
                    foreach ($createdRecords as $recordId)
                    {
                        $this->api->client()->dnsManagement()->deleteRdnsRecord($serviceId, $recordId);
                    }

                    $errors = $result->getErrors();

                    header('HTTP/1.1 400 Bad Request');
                    self::jsonEncode([
                        'error'=> $errors['rdata'][0] ?? ($result->message ?: "Record cannot be added")
                    ]);
                }

                $createdRecords[] = $this->findRecordIdByIp($serviceId, $value);
            }

            self::jsonEncode([
                'message'=>'Records added successfully'
            ]);
        }
        catch (\Exception $exc)
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode([
                'error'=>$exc->getMessage() != '' ? $exc->getMessage() : "Record cannot be added"
            ]);
        }
    }

    public function update($data)
    {
        try
        {
            $result = $this->api->client()->dnsManagement()->updateRdnsRecord(
                $this->context->requireServiceId(),
                $data['editId'],
                new UpdateRdnsRecordRequest($data['hostname'])
            );

            if ($result->success === false)
            {
                header('HTTP/1.1 400 Bad Request');
                self::jsonEncode([
                    'error'=>$result->message != '' ? $result->message : "Record cannot be edited"
                ]);
            }

            self::jsonEncode([
                'message'=>'Record edited successfully'
            ]);
        }
        catch (\Exception $exc)
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode([
                'error'=>$exc->getMessage() != '' ? $exc->getMessage() : "Record cannot be edited"
            ]);
        }
    }

    public function delete($data)
    {
        try
        {
            $result = $this->api->client()->dnsManagement()->deleteRdnsRecord(
                $this->context->requireServiceId(),
                $data['deleteId']
            );

            if ($result->success === false)
            {
                header('HTTP/1.1 400 Bad Request');
                self::jsonEncode([
                    'error'=>$result->message != '' ? $result->message : "Record cannot be deleted"
                ]);
            }

            self::jsonEncode([
                'message'=>'Record deleted successfully'
            ]);
        }
        catch (\Exception $exc)
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode([
                'error'=>$exc->getMessage() != '' ? $exc->getMessage() : "Record cannot be deleted"
            ]);
        }
    }

    /**
     * v3 create returns no record body, so the new record is located by its IP
     * in order to be able to roll a partial pool back.
     */
    private function findRecordIdByIp(int $serviceId, string $ip)
    {
        foreach ($this->getAllrDNSRecords() as $record)
        {
            if ($record->ip === $ip)
            {
                return $record->id;
            }
        }

        return null;
    }

    private function createIpv4Pool($ipPool, $mask)
    {
        $pool   = [];
        $ip_enc = ip2long($ipPool);

        //convert last (32-$mask) bits to zeroes
        $curr_ip         = $ip_enc | pow(2, (32 - $mask)) - pow(2, (32 - $mask));
        $ip_nmask        = self::translateBitmaskToNetmask((int)$mask);
        $ip_address_long = $ip_enc;
        $ip_nmask_long   = ip2long($ip_nmask);

        //caculate last usable address
        $ip_broadcast_invert = ~$ip_nmask_long;
        $ip_last             = ($ip_address_long | $ip_broadcast_invert) - 1;
        $ip_last_short       = long2ip($ip_last);

        $totalHost = (float)pow(2, (32 - $mask));

        if ($totalHost > 10000)
        {
            throw new \Exception(sprintf("Subnet %s/%s is too large. You are tring to add %s addresses.", $ipPool, $mask, $totalHost));
        }

        for ($pos = 0; $pos < pow(2, (32 - $mask)); ++$pos)
        {
            $ip     = long2ip((float)$curr_ip + $pos);
            $pool[] = $ip;

            if ($ip == $ip_last_short)
            {
                break;
            }
        }

        return $pool;
    }

    public static function translateBitmaskToNetmask($bitmask)
    {
        $maskMap = [
            0  => "0.0.0.0",
            1  => "128.0.0.0",
            2  => "192.0.0.0",
            3  => "224.0.0.0",
            4  => "240.0.0.0",
            5  => "248.0.0.0",
            6  => "252.0.0.0",
            7  => "254.0.0.0",
            8  => "255.0.0.0",
            9  => "255.128.0.0",
            10 => "255.192.0.0",
            11 => "255.224.0.0",
            12 => "255.240.0.0",
            13 => "255.248.0.0",
            14 => "255.252.0.0",
            15 => "255.254.0.0",
            16 => "255.255.0.0",
            17 => "255.255.128.0",
            18 => "255.255.192.0",
            19 => "255.255.224.0",
            20 => "255.255.240.0",
            21 => "255.255.248.0",
            22 => "255.255.252.0",
            23 => "255.255.254.0",
            24 => "255.255.255.0",
            25 => "255.255.255.128",
            26 => "255.255.255.192",
            27 => "255.255.255.224",
            28 => "255.255.255.240",
            29 => "255.255.255.248",
            30 => "255.255.255.252",
            31 => "255.255.255.254",
            32 => "255.255.255.255"
        ];

        return isset($maskMap[$bitmask]) ? $maskMap[$bitmask] : $bitmask;
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
