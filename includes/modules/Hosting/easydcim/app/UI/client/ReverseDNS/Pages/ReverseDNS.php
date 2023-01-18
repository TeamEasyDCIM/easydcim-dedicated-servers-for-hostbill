<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\ReverseDNS\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\DNS\AddRecord;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\DNS\DataContainer;

class ReverseDNS
{
    /**
     * @var EasyDCIM
     */
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    private function getDeviceInformation()
    {
        return $this->api->device->getInformation();
    }

    /**
     * @return array
     */
    public function getIPAddresses():array
    {
        $device = $this->getDeviceInformation();
        if (isset($device->ip_addresses))
        {
            $ipAddresses = $device->ip_addresses;
        }
        else
        {
            $additional  = explode(',', $device->metadata->{'Additional IP Addresses'});
            $primary     = [$device->metadata->{'IP Address'}];
            $ipAddresses = array_merge($primary, $additional);
        }
        foreach ($ipAddresses as $value)
        {
            $data[] =[
                'ipAddresses'=>$value
            ];
        }
        return empty($data) ? [] : $data;
    }

    public function getDNS()
    {
        $data    = [];
        $records = $this->getAllrDNSRecords();
        foreach ($records->rdns as $key => $value)
        {
            $data[] = [
                'id'=>$value->id,
                'ipAddress'=>$value->ip,
                'hostname'=>$value->from,
                'created'=>$value->created_at,
            ];
        }

        return empty($data) ? [] : $data;
    }

    protected function getAllrDNSRecords()
    {
        return $this->api->dnsManager->getRecords();
    }

    public function create($data)
    {
        try
        {
            if (!empty($data['reverseDNSMask']))
            {
                $mask = filter_var($this->formData['reverseDNSMask'], FILTER_SANITIZE_NUMBER_INT);
                $pool = $this->createIpv4Pool($data['reverseDNSIpAddress'],$mask);
                $createdRecords = [];
                foreach ($pool as $value)
                {
                    $rDNSModel     = new AddRecord();
                    $rDNSModel->setIp($value)
                        ->setRdata($data['reverseDNSHostname'])
                        ->setTtl($data['reverseDNSTTL']);
                    $dataContainer = new DataContainer();
                    $dataContainer->setData($rDNSModel);

                    $result = $this->api->dnsManager->createRecord($dataContainer);
                    if (isset($result->status) && $result->status == 'error')
                    {
                        foreach ($createdRecords as $record)
                        {
                            $this->api->dnsManager->deleteRecord($record['id']);
                        }
                        if (isset($response->errors->rdata[0]))
                        {
                            header('HTTP/1.1 400 Bad Request');

                            self::jsonEncode([
                                'error'=>$response->errors->rdata[0] ?: "Record cannot be added"
                            ]);
                        }else{
                            header('HTTP/1.1 400 Bad Request');

                            self::jsonEncode([
                                'error'=>$result->message ?: "Record cannot be added"
                            ]);
                        }
                    }else
                    {
                        $createdRecords[] = [
                            'id'=>end($response->rdns)->id
                        ];

                    }
                }
                self::jsonEncode([
                    'message'=>'Records added successfully'
                ]);
            }else
            {
                $rDNSModel     = new AddRecord();
                $rDNSModel->setIp($data['reverseDNSIpAddress'])
                    ->setRdata($data['reverseDNSHostname'])
                    ->setTtl($data['reverseDNSTTL']);
                $dataContainer = new DataContainer();
                $dataContainer->setData($rDNSModel);

                $result = $this->api->dnsManager->createRecord($dataContainer);
                if (isset($result->status) && $result->status == 'error')
                {
                    header('HTTP/1.1 400 Bad Request');

                    self::jsonEncode([
                        'error'=>$result->message != '' ? $result->message : "Record cannot be added"
                    ]);
                }else
                {
                    self::jsonEncode([
                        'message'=>'Record added successfully'
                    ]);
                }
            }

        }
        catch (\Exception $exc)
        {
        }
    }

    public function update($data)
    {
        try
        {
            $rDNSModel     = new AddRecord();
            $rDNSModel->setRdata($data['hostname']);

            $dataContainer = new DataContainer();
            $dataContainer->setData($rDNSModel);

            $result = $this->api->dnsManager->updateRecord($data['editId'],$dataContainer);
            if (isset($result->status) && $result->status == 'error')
            {
                header('HTTP/1.1 400 Bad Request');

                self::jsonEncode([
                    'error'=>$result->message != '' ? $result->message : "Record cannot be edited"
                ]);
            }else
            {
                self::jsonEncode([
                    'message'=>'Record edited successfully'
                ]);
            }
        }
        catch (\Exception $exc)
        {
        }
    }

    public function delete($data)
    {
        try
        {
            $result =  $this->api->dnsManager->deleteRecord($data['deleteId']);
            if (isset($result->status) && $result->status == 'error')
            {
                header('HTTP/1.1 400 Bad Request');

                self::jsonEncode([
                    'error'=>$result->message != '' ? $result->message : "Record cannot be deleted"
                ]);
            }else
            {
                self::jsonEncode([
                    'message'=>'Record deleted successfully'
                ]);
            }
        }
        catch (\Exception $exc)
        {
        }
    }

    private function createIpv4Pool($ipPool, $mask)
    {
        $pool   = [];
        $ip_enc = ip2long($ipPool);
        //convert last (32-$mask) bits to zeroes
        $curr_ip         = $ip_enc | pow(2, (32 - $mask)) - pow(2, (32 - $mask));
        $ips             = [];
        $ip_nmask        = self::translateBitmaskToNetmask((int)$mask);
        $ip_address_long = $ip_enc;
        $ip_nmask_long   = ip2long($ip_nmask);
        //caculate network address
        $ip_net = $ip_address_long & $ip_nmask_long;
        //caculate first usable address
        $ip_host_first = ((~$ip_nmask_long) & $ip_address_long);
        $ip_first      = ($ip_address_long ^ $ip_host_first) + 1;
        //caculate last usable address
        $ip_broadcast_invert = ~$ip_nmask_long;
        $ip_last             = ($ip_address_long | $ip_broadcast_invert) - 1;
        //caculate broadcast address
        $ip_last       = ($ip_address_long | $ip_broadcast_invert) - 1;
        $ip_last_short = long2ip($ip_last);
        $totalHost     = (float)pow(2, (32 - $mask));
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

    /**
     * @param array $data
     */
    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data'=>$data
        ]));
        die;
    }
}