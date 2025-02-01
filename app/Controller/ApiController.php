<?php

namespace App\Controller;

use App\Base\Response;
use App\Model\Event;

class ApiController extends Controller
{

    public function single_event(string|int $event_id)
    {
        $eventModel = new Event;
        $event = $eventModel->getEventWithAttendees($event_id);

        if (!$event) {
            return Response::json([
                'status' => 'faild',
                'message' => "Event not found.",
                'data' => []
            ], 404);
        }

        return Response::json($event, 200);
    }

    public function events()
    {
        $defaultPerPage = 5;

        $perPage = isset($_GET['limit']) ? (int)$_GET['limit'] : $defaultPerPage;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

        $eventModel = new Event;
        $events = $eventModel->paginate($perPage, $page);
        $totalUsers = $eventModel->count();
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

        return Response::json($data, 200);
    }
}
