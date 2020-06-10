<?php

namespace database\adaptors;

class Connection {

    protected $host;
    protected $port;
    protected $username;
    protected $password;
    protected $database_name;

    public function __construct($config) {
        $this->host = $config['db_host'];
        $this->port = $config['db_port'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->database_name =  $config['$database_name'];
    }

}