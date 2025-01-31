<?php

namespace App\Controller;

use App\Base\Auth;
use App\Base\Redirect;
use App\Model\Event;
use App\Model\User;

class HomeController extends Controller
{

    public function index()
    {

        $defaultPerPage = 5;

        $perPage = isset($_GET['limit']) ? (int)$_GET['limit'] : $defaultPerPage;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

        $eventModel = new Event;
        $events = $eventModel->paginate($perPage, $page, 1);
        $totalUsers = $eventModel->count(1);
        $totalPages = ceil($totalUsers / $perPage);

        $data = [
            'status' => 'success',
            'data' => [
                'events' => $events,
                'pagination' => [
                    'current_page' => $page,
                    'total_pages' => $totalPages,
                    'per_page' => $perPage,
                    'total_records' => $totalUsers
                ]
            ]
        ];

        return view('frontend/home', $data);
    }

    public function details(string $slug)
    {
        return view('frontend/details');
    }
}
