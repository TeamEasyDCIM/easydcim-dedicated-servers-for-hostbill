<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Api;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;

class EasyDCIMConfigFactory
{
    /**
     * @param array $serverParams
     * @param array|null $params
     * @return ClientAdapter
     */
    public function fromParams(array $serverParams, array $params = null):ClientAdapter
    {
        $config = [
            'serversecure' => $serverParams['secure'],
            'serverip' => $serverParams['ip'],
            'serverhostname' => $serverParams['host'],
            'serverusername' => $serverParams['username'],
            'serverpassword' => $serverParams['password'],
        ];
        if ($params != null)
        {
            $config['config'] = $params;
        }
        return new ClientAdapter($config);
    }
}