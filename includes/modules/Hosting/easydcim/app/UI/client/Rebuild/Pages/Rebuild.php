<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\Rebuild\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\SystemLogo;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\InstallOsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\DefaultOptions;

class Rebuild
{
    /**
     * @var EasyDCIMClient
     */
    protected $api;

    /**
     * @var IClient
     */
    protected $client;

    protected $params;

    /**
     * @var array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\OsAddonData>
     */
    protected $addons = [];

    /**
     * @var DefaultOptions
     */
    protected $options;

    public function __construct($api, $client, $params)
    {
        $this->api = $api;
        $this->client = $client;
        $this->params = $params;
        $this->options = new DefaultOptions($api);
    }

    public function prepareData()
    {
        $data = [];
        $caTemplates = $this->params['options']['caTemplates'];

        foreach ($caTemplates as $value)
        {
            $values = explode('_', $value);
            $this->addons = $this->getAddons($values[1]);

            $data[] = [
                'id'          => $values[1],
                'Description' => $values[0],
                'extras'      => $this->getExtras(),
                'diskLayout'  => $this->getDiskLayout(),
            ];
        }

        return $data;
    }

    public function getDataForModal($templateId)
    {
        $this->addons = $this->getAddons($templateId);

        self::jsonEncode([
            'extras'     => $this->getExtras(),
            'diskLayout' => $this->getDiskLayout(),
            'username'   => $this->params['username'],
        ]);
    }

    /**
     * Addons the location's provisioning server offers for one OS template.
     */
    protected function getAddons($templateId)
    {
        return $this->options->getAddonsList($templateId, $this->params['options']['LocationID']);
    }

    protected function getExtras()
    {
        $options = [];

        foreach ($this->addons as $item) {
            if ($item->type != "disklayout") {
                $options[] = [
                    'key' => $item->id,
                    'value' => $item->description
                ];
            }
        }

        return $options;
    }

    protected function getDiskLayout()
    {
        $options = [];

        foreach ($this->addons as $item) {
            if ($item->type == "disklayout") {
                $options[] = [
                    'key' => $item->id,
                    'value' => $item->description
                ];
            }
        }

        return $options;
    }

    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data'=>$data
        ]));
        die;
    }

    public function installOS($data)
    {
        $deviceId = $this->client->getEasyServerID();

        $request = new InstallOsRequest(
            template: (int) $data['templateCaId'],
            hostname: $data['rebuildHostname'] ?? null,
            username: $data['rebuildUsername'] ?? null,
            password: $data['rebuildPassword'] ?? null,
            rootPassword: $data['rebuildRootSSHPassword'] ?? null,
            // v2 sent both the disk layout and the extras as "disk_addon", so
            // the extras silently replaced the layout. They are distinct here.
            diskAddon: isset($data['rebuildDiskLayout']) && $data['rebuildDiskLayout'] !== ''
                ? (int) $data['rebuildDiskLayout']
                : null,
            extras: isset($data['rebuildExtras']) && $data['rebuildExtras'] !== ''
                ? array_values((array) $data['rebuildExtras'])
                : null
        );

        $result = $this->api->admin()->osInstallation()->installOs($deviceId, $request);

        if ($result->success === false)
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode([
                'error'=>$result->message
            ]);
        }

        self::jsonEncode([
            'message'=>$result->message
        ]);
    }

    public function cancelInstall()
    {
        $result = $this->api->admin()->osInstallation()->cancelOsInstallation($this->client->getEasyServerID());

        if ($result->success === false)
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode([
                'error'=>$result->message
            ]);
        }

        self::jsonEncode([
            'message'=>"Installation was canceled correctlly"
        ]);
    }

    public function getOsInstallInformation()
    {
        $deviceId = $this->client->getEasyServerID();

        $device = $this->api->admin()->devices()->show($deviceId)->data;
        $metadata = (array) ($device?->metadata ?? []);

        // v3 reports the provisioning state as a message rather than a status.
        $installation = $this->api->admin()->osInstallation()->getOsInstallationInfo($deviceId);
        $instalationStatus = (string) ($installation->data?->message ?? '');

        $currentOs = $metadata['OS'] ?? '';

        return [
            'hostInformation'             => $metadata['IP Address'] ?? '',
            'hostname'                    => $metadata['Hostname'] ?? '',
            'currentOS'                   => $currentOs,
            'osIsCurrentlyBeingInstalled' => empty($device?->osInstallation) ? 'NO' : 'YES',
            'username'                    => $this->params['username'],
            'sshPassword'                 => $metadata['SSH Password'] ?? '',
            'sshRootPassword'             => $metadata['SSH Root Password'] ?? '',
            'macAddress'                  => $metadata['MAC Address'] ?? '',
            'path'                        => SystemLogo::getLogo($currentOs),
            'installationStatus'          => $instalationStatus == '' ? 'No Installation' : $instalationStatus,
        ];
    }
}
