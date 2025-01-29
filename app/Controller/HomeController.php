<?php

namespace App\Controller;

use App\Model\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages/dashboard');
    }

}
