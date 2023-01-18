<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use ModulesGarden\Servers\EasyDCIMv2\App\Enum\Config;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Connection;

class Database
{
    protected $manager;
    protected $schema;
    protected $connection;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->manager = new Capsule();
        $this->manager->addConnection([
            'driver'    => Config::DB_TYPE,
            'host'      => Config::DB_HOST,
            'database'  => Config::DB_NAME,
            'username'  => Config::DB_USER,
            'password'  => Config::DB_PASS,
        ],'default');

        $this->manager->setAsGlobal();
        $this->manager->bootEloquent();
        $this->connection = $this->manager->getConnection('default');
        $this->schema = $this->manager->schema('default');
    }

    /**
     * @return Capsule
     */
    public function getManager(): Capsule
    {
        return $this->manager;
    }

    /**
     * @return Builder
     */
    public function getSchema(): Builder
    {
        return $this->schema;
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

}