<?php

namespace App\libs;

class Route
{

    private static array $routes = [];


    public static function get($uri, $callback): void
    {
        $uri = trim($uri, '/');
        self::$routes['GET'][$uri] = $callback;
    }

    public static function post($uri, $callback): void
    {
        $uri = trim($uri, '/');
        self::$routes['POST'][$uri] = $callback;
    }

    public static function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];        

        $uri = trim($uri, '/');

        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes[$method] as $route => $callback) {

            if (str_contains($route, ':')) {
                $route = preg_replace('#:[a-zA-Z0-9]+#', '([a-zA-Z0-9]+)', $route);
            }

            if (preg_match("#^$route$#", $uri, $matches)) {
                
                $params = array_slice($matches, 1);                
                
                if( is_array($callback) ){
                    $controller = new $callback[0];
                    $controller->{$callback[1]}(...$params);
                }

                return;
            }
        }

        http_response_code(404);
    }
}
