<?php

namespace App\Middleware;

use App\Base\Auth;
use App\Base\Redirect;

class GuestMiddleware
{
    /**
     * Handle guest user access control.
     *
     * @return bool Returns true if the user is a guest, otherwise redirects to the dashboard.
     */
    public static function handler(): bool
    {
        if (Auth::check()) {
            Redirect::to('/dashboard');
            exit; 
        } 
        
        return true;
    }
}
