<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;

class TestConnection
{
    protected $module;

    /**
     * @var ClientAdapter
     */
    protected $client;

    public function __construct($module)
    {
        $this->module = $module;
        $this->client = (new EasyDCIMConfigFactory())->fromParams($this->module->connection);
    }

    public function execute():string
    {
        $api = new EasyDCIM($this->client);
        $version = $api->system->getVersion();

        if($version>0 && $version->status != 'error')
        {
            return "success";
        }else
        {
            return 'error';
        }
    }
}