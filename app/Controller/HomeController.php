<?php

namespace App\Controller;

use App\Base\Auth;
use App\Base\Redirect;
use App\Model\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        Redirect::to('/login');
    }
}
