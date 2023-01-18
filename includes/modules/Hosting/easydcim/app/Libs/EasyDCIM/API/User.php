<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\API;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Abstracts\AbstractEasyDCIMAPI;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Users\UserContainer;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Users\UserDetails;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Users\UserLoginData;

/**
 * Description of User
 *
 * @author Mateusz Pawłowski
 */
class User extends AbstractEasyDCIMAPI
{

    /**
     * EasyDCIM User - Create user
     * @documentation https://www.easydcim.com/api/index.html#api-User-Create
     * @return JSON object
     * @throws error
     */
    public function create(UserContainer $model)
    {
        return $this->api->post($model->toArray())->execut('user');
    }

    /**
     * EasyDCIM User - Check if user exists
     * @documentation https://www.easydcim.com/api/index.html#api-User-UserExists
     * @return JSON object
     * @throws error
     */
    public function checkIfExists(UserDetails $model)
    {
        return $this->api->get($model->toArray())->execut('user/exists');
    }

    /**
     * EasyDCIM User - Client Auto Login Link
     * @documentation https://www.easydcim.com/api/index.html#api-User-ClientKeyLogin
     * @return JSON object
     * @throws error
     */
    public function getKeyLogin(UserLoginData $model)
    {
        return $this->api->post($model->toArray())->execut('user/client-key-login');
    }

}
