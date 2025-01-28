<?php

namespace App\Controller;

use App\Middleware\Middleware;

class Controller extends Middleware
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
