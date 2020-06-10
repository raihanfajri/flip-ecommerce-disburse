<?php 

namespace helpers;

use Exception;

class Router {

    private static $avail_routes = array();

    private static function register($path, $method, $function) {
        if (empty($path)) {
            $path = "/";
        }

        self::$avail_routes[$path] = [
            $method => $function
        ];
    }

    public static function post($path, $function) {
        self::register($path, "POST", $function);
    }

    public static function get($path, $function) {
        self::register($path, "GET", $function);
    }

    public static function run() {
        try {
            $parsed_url = parse_url($_SERVER['REQUEST_URI']);
            $path = $parsed_url['path'];

            if (!isset(self::$avail_routes[$path])) {
                echo "404 not found";
                return;
            }

            $method = $_SERVER['REQUEST_METHOD'];

            if (!isset (self::$avail_routes[$path][$method])) {
                echo "Method not allowed";
                return;
            }

            $function = self::$avail_routes[$path][$method];
            self::execFunction($function);
        }
        catch(Exception $e) {
            Log::error($e);
            throw new Exception($e->getMessage(), $e->getCode());
        }       
    }

    private static function execFunction($function) {
        $function = explode("@", $function);

        $controller_name = "controllers\\" . $function[0];
        $function_name = $function[1];

        $controller = new $controller_name();

        return $controller->$function_name($_REQUEST);
    }
}