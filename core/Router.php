<?php

namespace Core;


class Router
{
    public static function route(array $url)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        // controller
        $controller = (isset($url[0]) && $url[0] != '') ? '\App\Controllers\\' . ucwords($url[0]) : '\App\Controllers\\' . DEFAULT_CONTROLLER;
        $controller_name = $controller;
        array_shift($url);

        // method(action)
        $method = (isset($url[0]) && $url[0] != '') ? strtolower($url[0]) : "index";
        array_shift($url);

        //params
        $params = $url;

        if(!class_exists($controller)) {
            throw new \Exception("Controller not found");
        } else {
            $dispatch = new $controller($controller_name, $method);
        }
      
        if (method_exists($controller, $method)) {
            call_user_func_array([$dispatch, $method], $params);
        } else {
            throw new \Exception("Method does not exist in {$controller_name} Controller");
        }
    }
}