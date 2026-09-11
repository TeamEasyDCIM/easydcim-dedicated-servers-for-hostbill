<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\IsoImages\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation\CreateIsoImageRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation\ListIsoImagesRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation\UpdateIsoImageRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

class IsoImages
{
    public const STATUS_SUCCESS = 'lu-label--success';
    public const STATUS_DANGER = 'lu-label--danger';
    public const STATUS_WARNING = 'lu-label--warning';
    public const STATUS_DEFAULT = 'lu-label--default';

    /**
     * @var EasyDCIMClient
     */
    protected $api;

    /**
     * @var IClient
     */
    protected $client;

    /**
     * Download states with the WHMCS module's label (lang edcUi) and badge colour.
     */
    protected static $statusMap = [
        1 => ['iso_waiting', 'lu-badge--warning'],
        2 => ['iso_downloading', 'lu-badge--info'],
        3 => ['iso_completed', 'lu-badge--success'],
        4 => ['iso_error', 'lu-badge--danger'],
    ];

    public function __construct($api, $client)
    {
        $this->api = $api;
        $this->client = $client;
    }

    /**
     * ISO images the account's owner has registered.
     *
     * API v3 scopes ISO images to the user rather than to a device, so the list
     * is whatever the impersonated user owns.
     */
    public function getIsoImages()
    {
        $data = [];

        try {
            $isoImages = $this->api->client()->osInstallation()->listAllIsoImages(new ListIsoImagesRequest());
        } catch (\Exception $ex) {
            return $data;
        }

        foreach ($isoImages as $isoImage)
        {
            $status = self::$statusMap[(int) $isoImage->status] ?? ['iso_unknown', ''];

            $data[] = [
                'id' => base64_encode(json_encode([
                    'id'=>$isoImage->id,
                    'name'=>$isoImage->name,
                    'iso_url'=>$isoImage->isoUrl,
                ])),
                'Id' => $isoImage->id,
                'name' => $isoImage->name,
                'iso_url' => $isoImage->isoUrl,
                'statusKey' => $status[0],
                'badgeClass' => $status[1],
                // v3 reports a download status message; WHMCS shows it as the badge's tooltip.
                'message' => ($isoImage->download === null ? null : $isoImage->download->message) ?? '',
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
            $result = $this->api->client()->osInstallation()->createIsoImage(new CreateIsoImageRequest(
                (string) $data['name'],
                (string) $data['iso_url']
            ));

            if ($result->success === false)
            {
                header('HTTP/1.1 400 Bad Request');
                self::jsonEncode([
                    'error'=>$result->message != '' ? $result->message : "Record cannot be added"
                ]);
            }

            self::jsonEncode([
                'message'=>'Task has been successfully added to the queue'
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
            $result = $this->api->client()->osInstallation()->updateIsoImage(
                $data['updateId'],
                new UpdateIsoImageRequest((string) $data['name'])
            );

            if ($result->success === false)
            {
                header('HTTP/1.1 400 Bad Request');
                self::jsonEncode([
                    'error'=>$result->message != '' ? $result->message : "Record cannot be edited"
                ]);
            }

            self::jsonEncode([
                'message'=>'ISO Image has been updated successfully'
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
            $result = $this->api->client()->osInstallation()->deleteIsoImage($data['deleteId']);

            if ($result->success === false)
            {
                header('HTTP/1.1 400 Bad Request');
                self::jsonEncode([
                    'error'=>$result->message != '' ? $result->message : "Record cannot be deleted"
                ]);
            }

            self::jsonEncode([
                'message'=>'ISO Image has been deleted successfully'
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

    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data'=>$data
        ]));
        die;
    }
}
