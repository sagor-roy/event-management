<?php

namespace App\Controller;


class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages/events/create');
    }

    public function list()
    {
        return view('pages/events/list');
    }

}
