<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Users;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of CreateOrder
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class UserLoginData extends Serializer
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $path;

    /*
     * Easy User ID
     * 
     * @params integer $id
     * @return object $this;
     * 
     */

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /*
     * Easy Email address
     * 
     * @params string $email
     * @return object $this;
     * 
     */

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /*
     * Easy login path
     * 
     * @params string $path
     * @return object $this;
     * 
     */

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

}
