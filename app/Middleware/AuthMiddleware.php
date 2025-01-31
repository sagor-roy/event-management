<?php

namespace App\Middleware;

use App\Base\Auth;
use App\Base\Redirect;

class AuthMiddleware
{
    /**
     * Handle authentication check before allowing access.
     *
     * @return bool Returns true if the user is authenticated, otherwise redirects to the login page.
     */
    public static function handler(): bool
    {
        if (Auth::check()) {
            return true;
        } else {
            Redirect::to('/login'); 
            exit;
        }
    }
}
