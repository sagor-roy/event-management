<?php

namespace App\Controller;

use App\Middleware\Middleware;
session_start();
class Controller extends Middleware
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
