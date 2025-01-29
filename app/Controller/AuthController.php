<?php

namespace App\Controller;

use App\Model\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

}
