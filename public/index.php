<?php

require_once __DIR__ . '/../autoload.php';

date_default_timezone_set('Asia/Jakarta');

use helpers\Router;
use helpers\Env;

Env::load();

Router::get("/", "DisburseController@detail");

Router::run();