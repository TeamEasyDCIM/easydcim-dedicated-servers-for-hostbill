<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

class InstallParams extends Serializer
{
    /**
     * @var integer $template
     */
    protected $template;

    /**
     * @var integer $disk_addon
     */
    protected $disk_addon;

    /**
     * @var string $hostname
     */
    protected $hostname;

    /**
     * @var string $template
     */
    protected $username;

    /**
     * @var string $template
     */
    protected $password;

    /**
     * @var string $root_password
     */
    protected $root_password;

    /**
     * @var array
     */
    protected $filter = [];

    /**
     * @var array
     */
    protected $extras = [];

    /**
     * Set Os template ID
     *
     * $params integer $template
     * @return object $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Set Hostname
     *
     * $params string $hostname
     * @return object $this
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
        return $this;
    }

    /**
     * Set Os Username
     *
     * $params string $username
     * @return object $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Set Os Password
     *
     * $params string $password
     * @return object $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Set Root Password
     *
     * $params string $rootPassword
     * @return object $this
     */
    public function setRootPassword($rootPassword)
    {
        $this->root_password = $rootPassword;
        return $this;
    }


    /**
     * @param array $filter
     * @return $this
     */
    public function setFilter(array $filter)
    {
        $this->filter = $filter;
        return $this;
    }


    /**
     * @param $disk_addon
     * @return $this
     */
    public function setDiskAddon($disk_addon)
    {
        $this->disk_addon = $disk_addon;
        return $this;
    }


    /**
     * @param array $extras
     * @return $this
     */
    public function setExtras(array $extras)
    {
        $this->extras = $extras;
        return $this;
    }




}