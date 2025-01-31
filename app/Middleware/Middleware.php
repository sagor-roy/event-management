<?php

namespace App\Middleware;

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

class Middleware
{
    /**
     * List of route middleware and their associated classes.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => AuthMiddleware::class, 
        'guest' => GuestMiddleware::class 
    ];

    /**
     * Handle a middleware by its name and execute its handler.
     *
     * @param string $middlewareName The name of the middleware to handle
     * @return mixed The result of the middleware handler (true or redirection)
     */
    public function middleware($middlewareName)
    {
        // Check if the middleware exists in the list
        if (isset($this->routeMiddleware[$middlewareName])) {
            $middleware = $this->routeMiddleware[$middlewareName];  
            $middleware = new $middleware(); 
            return $middleware->handler(); 
        }

        return false;
    }
}
