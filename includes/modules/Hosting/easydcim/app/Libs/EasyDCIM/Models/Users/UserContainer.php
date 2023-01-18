<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Users;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of CreateOrder
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class UserContainer extends Serializer
{

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var integer
     */
    protected $role;

    /*
     * Data container
     * 
     * @params object $data
     * @return object $this;
     * 
     */

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /*
     * Easy DCIM role ID
     * 
     * @params integer $role
     * @return object $this;
     * 
     */

    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

}
