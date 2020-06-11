<?php

namespace models\Databases;

use database\adaptors\Mysql;

class BaseDatabaseModel extends Mysql {

    protected $database;
    protected $connection;

}