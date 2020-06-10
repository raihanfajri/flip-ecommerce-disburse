<?php


if (! function_exists('env')) {

    function env($key, $default = null)
    {
        return $_ENV[$key] ?? $default;;
    }
}


if (! function_exists('config')) {

    function config($config_name = "", $key = "")
    {
        $default = "";

        if (empty($config_name)) {
            return $default;
        }

        $config_path = __DIR__. "/../config/$config_name.php";

        if (!file_exists($config_path)) {
            return $default;
        }
        
        $config = require __DIR__. "/../config/database.php";;

        if (empty($key)) {
            return $config;
        }

        if (!isset($config[$key])) {
            return $default;
        }

        return $config[$key];
    }
}