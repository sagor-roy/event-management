<?php

namespace App\Middleware;

use App\Base\Auth;
use App\Base\Redirect;

class AuthMiddleware
{
    public static function handler()
    {
        if (Auth::check()) {
            return true;
        } else {
            Redirect::to('/login');
        }
    }
}
