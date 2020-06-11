<?php

namespace models\Databases;

use helpers\Exception\BaseException;

class BaseDatabaseModel {

    protected $database = "default";
    protected $connection;

    public function __construct() {
        $config = config('database', $this->database);
        $connection_class =  "database\adaptors\\" . ucfirst($config['db_connection']);

        if (!class_exists($connection_class)) {
            throw new BaseException("Could not find any Class with name $connection_class", 400);
        }

        $this->connection = new $connection_class($config);
    }

    protected function get() {

    }

    protected function first() {

    }

    protected function save() {
        
    }

}