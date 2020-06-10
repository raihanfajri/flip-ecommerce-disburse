<?php

namespace helpers;

class Log {

    private static $file_path = __DIR__."/../logs/";
    private static $file_name;
    private static $full_path;

    public function __construct() {
       
    }

    public static function info(string $log) {
        $errorLog = "Info : $log";

        self::write($errorLog);
    }

    public static function error(string $log) {
        $errorLog = "Error : $log";

        self::write($errorLog);
    }

    private static function write(string $log, $log_name = null) {
        $dateTime = Date("Y-m-d H:i:s");
        $today = explode(' ', $dateTime)[0];

        self::$file_name = empty($log_name) ? "debug-$today.log" : $log_name;
        self::$full_path = self::$file_path . self::$file_name;

        $formattedLog = "[$dateTime] $log\n";

        if (file_exists(self::$full_path)){
            $file = fopen(self::$full_path, "a");
        }else{
            $file = fopen(self::$full_path, "w");
        }

        fwrite($file, $formattedLog);
        fclose($file);
    }
}