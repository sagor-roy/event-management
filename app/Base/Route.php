<?php

namespace App\Base;

class Route
{
    /**
     * Stores all registered routes categorized by HTTP method.
     *
     * @var array
     */
    private static array $routes = [];

    /**
     * Register a GET route.
     *
     * @param string $uri The URI pattern for the route
     * @param callable|array $callback The callback function or controller method to execute
     * @return void
     */
    public static function get(string $uri, $callback): void
    {
        self::$routes['GET'][$uri] = $callback;
    }

    /**
     * Register a POST route.
     *
     * @param string $uri The URI pattern for the route
     * @param callable|array $callback The callback function or controller method to execute
     * @return void
     */
    public static function post(string $uri, $callback): void
    {
        self::$routes['POST'][$uri] = $callback;
    }

    /**
     * Register a PUT route.
     *
     * @param string $uri The URI pattern for the route
     * @param callable|array $callback The callback function or controller method to execute
     * @return void
     */
    public static function put(string $uri, $callback): void
    {
        self::$routes['PUT'][$uri] = $callback;
    }

    /**
     * Handle the incoming HTTP request by matching it to a registered route.
     *
     * @return void
     */
    public static function handleRequest(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Check if the request method exists in the registered routes
        if (!isset(self::$routes[$method])) {
            http_response_code(404);
            abort_404();
            return;
        }

        foreach (self::$routes[$method] as $pattern => $callback) {
            // Check if the requested URI matches a registered route pattern
            if (preg_match(self::convertToRegex($pattern), $uri, $matches)) {
                array_shift($matches); 

                // If the callback is a controller action
                if (is_array($callback)) {
                    $controller = new $callback[0](); 
                    $action = $callback[1]; 
                    echo call_user_func_array([$controller, $action], array_values($matches)); 
                } 
                // If the callback is a closure (anonymous function)
                elseif (is_callable($callback)) {
                    echo call_user_func_array($callback, array_values($matches)); 
                }
                return;
            }
        }

        // If no route matches, return 404 error
        http_response_code(404);
        abort_404();
    }

    /**
     * Convert a route pattern with placeholders to a regular expression.
     *
     * @param string $pattern The route pattern (e.g., "/user/{id}")
     * @return string The converted regex pattern
     */
    private static function convertToRegex(string $pattern): string
    {
        return "#^" . preg_replace('/{([\w]+)}/', '(?P<\1>[\w-]+)', $pattern) . "$#";
    }
}
