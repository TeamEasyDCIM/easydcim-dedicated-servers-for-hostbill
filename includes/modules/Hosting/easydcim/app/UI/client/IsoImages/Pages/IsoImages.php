<?php
namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\IsoImages\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os\DataContainer;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os\IsoImagesRecord;

class IsoImages
{
    public const STATUS_SUCCESS = 'lu-label--success';
    public const STATUS_DANGER = 'lu-label--danger';
    public const STATUS_WARNING = 'lu-label--warning';
    public const STATUS_DEFAULT = 'lu-label--default';

    /**
     * @var EasyDCIM
     */
    protected $api;

    /**
     * @var ClientAdapter
     */
    protected $client;
    protected static $statusMap = [
        '1'=>'Waiting',
        '2'=>'Started',
        '3'=>'Finished',
        '4'=>'Error',
    ];

    public function __construct($api,$client)
    {
        $this->api = $api;
        $this->client = $client;
    }

    public function getIsoImages()
    {
        foreach ($this->api->os->getIsoImagesForDevice($this->client->getEasyServerID()) as $isoImage)
        {
            $progress = 0;
            $isoData = unserialize($isoImage->data);
            $status = self::$statusMap[$isoImage->status];
            switch ($status)
            {
                case 'Finished':
                    $colorStatus = self::STATUS_SUCCESS;
                    break;
                case 'Started':
                    $colorStatus = self::STATUS_WARNING;
                    $progress = intval($isoData['downloadedBytes']/$isoData['downloadTotal']*100);
                    break;
                case 'Error':
                    $colorStatus = self::STATUS_DANGER;
                    break;
                default:
                    $status = 'Waiting';
                    $colorStatus = self::STATUS_DEFAULT;
                    break;
            }

            $data[] = [
                'id' => base64_encode(json_encode([
                    'id'=>$isoImage->id,
                    'name'=>$isoImage->name,
                    'iso_url'=>$isoImage->iso_url,
                ])),
                'Id' => $isoImage->id,
                'name' => $isoImage->name,
                'iso_url' => $isoImage->iso_url,
                'status' => $status,
                'data' => $isoData,
                'colorStatus' => $colorStatus,
                'progress' => $progress,
            ];
        }

        return $data;
    }

    public function getJSONIsoImages()
    {
        self::jsonEncode([
            'result'=>$this->getIsoImages()
        ]);
    }

    public function create($data)
    {
        try
        {
            $isoImagesRecord     = new IsoImagesRecord();
            $isoImagesRecord->setName($data['name']);
            $isoImagesRecord->setIsoUrl($data['iso_url']);
            $isoImagesRecord->setDeviceId($this->client->getEasyServerID());

            $dataContainer = new DataContainer();
            $dataContainer->setData($isoImagesRecord);

            $result = $this->api->os->createIsoImage($dataContainer);
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
        catch (\Exception $exc)
        {
            header('HTTP/1.1 400 Bad Request');

            self::jsonEncode([
                'error'=>$exc->getMessage() != '' ? $exc->getMessage() : "Record cannot be deleted"
            ]);
        }
    }

    public function update($data)
    {
        try
        {
            $isoImagesRecord     = new IsoImagesRecord();
            $isoImagesRecord->setName($data['name']);
            $isoImagesRecord->setDeviceId($this->client->getEasyServerID());

            $dataContainer = new DataContainer();
            $dataContainer->setData($isoImagesRecord);

            $result = $this->api->os->updateIsoImage($dataContainer,$data['updateId']);
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
            header('HTTP/1.1 400 Bad Request');

            self::jsonEncode([
                'error'=>$exc->getMessage() != '' ? $exc->getMessage() : "Record cannot be deleted"
            ]);
        }
    }

    public function delete($data)
    {
        try
        {
            $result = $this->api->os->deleteIsoImage($data['deleteId']);
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
            header('HTTP/1.1 400 Bad Request');

            self::jsonEncode([
                'error'=>$exc->getMessage() != '' ? $exc->getMessage() : "Record cannot be deleted"
            ]);
        }
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