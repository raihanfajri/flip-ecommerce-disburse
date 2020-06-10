<?php

namespace helpers;

class Env {

    private static $path_env = __DIR__."/../.env";

    public static function load() {
        if (file_exists(self::$path_env)){
            $handle = fopen(self::$path_env, "r");

            while (($line = fgets($handle)) !== false) {
                $exploded_line = explode('=', $line);

                if (sizeof ($exploded_line) >= 2) {
                    $key = $exploded_line[0];

                    $value = trim($exploded_line[1]);
                    
                    if (!empty($value)) $_ENV[$key] = $value;
                }
            }
        
            fclose($handle);
        }

    }
    
}