<?php

namespace models;

class BaseModel {

    protected $table;
    protected $connection;

    public function __construct() {
        $config = require __DIR__. "/../config/database.php";;
        $connection_class =  "database\adaptors\\" . ucfirst($config['db_connection']);
        $this->connection = new $connection_class($config);
    }

    protected function get() {

    }

    protected function first() {

    }

    protected function save() {
        
    }

}