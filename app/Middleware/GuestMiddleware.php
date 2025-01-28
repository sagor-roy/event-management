<?php

namespace App\Middleware;

use App\Base\Auth;
use App\Base\Redirect;

class GuestMiddleware
{
    public static function handler()
    {
        if (Auth::check()) {
            Redirect::to('/');
        } else {
            return true;
        }
    }
}
