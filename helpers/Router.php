<?php 

namespace helpers;

use helpers\Constants\ErrorConstant;
use helpers\Constants\MessageConstant;
use helpers\Exception\BaseException;
use helpers\Http\Request;

class Router {

    private static $avail_routes = array();

    private static function register($path, $method, $function) {
        if (empty($path)) {
            $path = "/";
        }

        self::$avail_routes[$path][$method] = $function;
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
                throw new BaseException(
                    MessageConstant::MESSAGE_CODE_404_NOT_FOUND, 
                    ErrorConstant::ERROR_CODE_404_NOT_FOUND, 
                    404);
            }

            $method = $_SERVER['REQUEST_METHOD'];

            if (!isset (self::$avail_routes[$path][$method])) {
                throw new BaseException(
                    MessageConstant::MESSAGE_CODE_405_NOT_ALLOWED, 
                    ErrorConstant::ERROR_CODE_404_NOT_FOUND,
                    405);
            }

            $function = self::$avail_routes[$path][$method];
            self::execFunction($function);
            return;
        }
        catch(BaseException $e) {
            Log::error($e);
            $e->send();
        }       
    }

    private static function execFunction($function) {
        $function = explode("@", $function);

        $controller_name = "controllers\\" . $function[0];
        $function_name = $function[1];

        $controller = new $controller_name();

        $request = new Request();

        $controller->$function_name($request);
        return;
    }
}