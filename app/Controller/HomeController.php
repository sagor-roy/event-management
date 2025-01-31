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
        $event_status = 1; // only active events fetch

        $perPage = isset($_GET['limit']) ? (int)$_GET['limit'] : $defaultPerPage;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

        $eventModel = new Event;
        $events = $eventModel->paginate($perPage, $page, $event_status);
        $totalUsers = $eventModel->count($event_status);
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
        $eventModel = new Event;
        $event =  $eventModel->getFirst('slug', '=', $slug);

        if (!$event) {
            http_response_code(404);
            echo "404 NOT FOUND";
            exit;
        }

        $data = [
            'event' => $event
        ];

        return view('frontend/details', $data);
    }
}
