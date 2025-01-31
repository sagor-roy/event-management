<?php

namespace App\Controller;

use App\Base\Auth;
use App\Base\Redirect;
use App\Model\User;

class HomeController extends Controller
{

    public function index()
    {
        return view('frontend/home');
    }

    public function details(string $slug)
    {
        return view('frontend/details');
    }
}
