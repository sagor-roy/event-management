<?php

namespace App\Base;

class Route
{
    private static array $routes = [];

    // Add GET route
    public static function get(string $uri, $callback): void
    {
        self::$routes['GET'][$uri] = $callback;
    }

    // Add POST route
    public static function post(string $uri, $callback): void
    {
        self::$routes['POST'][$uri] = $callback;
    }

    public static function put(string $uri, $callback): void
    {
        self::$routes['PUT'][$uri] = $callback;
    }

    // Handle the incoming request
    public static function handleRequest(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach (self::$routes[$method] as $pattern => $callback) {
            if (preg_match(self::convertToRegex($pattern), $uri, $matches)) {
                array_shift($matches);

                if (is_array($callback)) {
                    $controller = new $callback[0]();
                    $action = $callback[1];
                    echo call_user_func_array([$controller, $action], array_values($matches)); 
                } elseif (is_callable($callback)) {
                    echo call_user_func_array($callback, array_values($matches)); 
                }
                return;
            }
        }

        http_response_code(404);
        abort_404();
    }

    private static function convertToRegex(string $pattern): string
    {
        return "#^" . preg_replace('/{([\w]+)}/', '(?P<\1>[\w-]+)', $pattern) . "$#";
    }
}
