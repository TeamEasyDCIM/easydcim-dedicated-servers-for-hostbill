<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\AccessList\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;

class AccessList
{
    /**
     * @var EasyDCIM
     */
    protected $api;
    protected $serverId;
    /**
     * @var array
     */
    protected $accessList = [];

    public function __construct($api,$serverId)
    {
        $this->api = $api;
        $this->serverId = $serverId;
        $this->accessList = $this->getAccessList();
    }

    /**
     * @return array
     */
    public function getData():array
    {
        foreach ($this->accessList as $key=>$value)
        {
            $data[] = [
                'name'=>$value->name,
                'username'=>$value->username,
                'password'=>$value->password,
            ];
        }
        return empty($data) ? [] : $data ;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getAccessList(): array
    {

//        if (!$this->isModuleActive('password-manager'))
//        {
//            throw new \Exception('passwordManagerNotActive');
//        }
//        if (!$this->checkIsPageEnable())
//        {
//            throw new Exception('noAccessPasswordManager');
//        }
//        $client = (new EasyDCIMConfigFactory())->fromParams();

        $list = [];
        foreach ($this->api->passwordManagement->getAccessList() as $item) {
            if(isset($item->device_id) && $item->device_id == $this->serverId) {
                $list[] = $item;
            }
        }

        return $list;
    }

    /**
     * Get all activated module in Easy DCIM
     *
     * @return array
     **/

    private function getModules()
    {
        return $this->api->system->getModules();
    }

    /**
     * Check Module Is Active
     *
     * @param string $name
     * @return boolean
     */
    private function isModuleActive($name)
    {
        $modules = $this->getModules();

        return isset($modules->{$name});
    }
}