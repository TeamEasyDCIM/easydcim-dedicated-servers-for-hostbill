<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of CreateOrder
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class OrderService extends Serializer
{

    protected $hostname;
    protected $template;
    protected $username;
    protected $password;
    protected $root_password;
    protected $monthly_traffic_limit;
    protected $additional_ips;
    protected $additional_ips_number;
    protected $access_level;
    protected $customFields = null;

    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
        return $this;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setRootPassword($rootPassword)
    {
        $this->root_password = $rootPassword;
        return $this;
    }

    public function setMonthly_traffic_limit($monthly_traffic_limit)
    {
        $this->monthly_traffic_limit = $monthly_traffic_limit;
        return $this;
    }

    public function setMonthlyTrafficLimit($monthly_traffic_limit)
    {
        $this->monthly_traffic_limit = $monthly_traffic_limit;
        return $this;
    }

    public function setAdditionalIps($additional_ips)
    {
        $this->additional_ips = $additional_ips;
        return $this;
    }

    public function setAdditionalIpsNumber($additionalIpsNumber)
    {
        $this->additional_ips_number = $additionalIpsNumber;
        return $this;
    }

    public function setAccess_level($access_level)
    {
        $this->access_level = $access_level;
        return $this;
    }

    public function setAccessLevel($access_level)
    {
        $this->access_level = $access_level;
        return $this;
    }

    public function setCustomFields($customFields = [])
    {
        $this->customFields = $customFields;
        return $this;
    }

    public function toArray()
    {
        $info            = parent::toArray();
        $additionalField = $info['customFields'];
        unset($info['customFields']);
        foreach ($additionalField as $key => $value)
        {
            $info[$key] = $value;
        }
        return $info;
    }

}
