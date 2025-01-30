<?php

namespace App\Controller;

use App\Base\Auth;
use App\Base\Redirect;
use App\Model\Attendee;
use App\Model\Event;
use App\Model\User;

class AttendeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(int|string $id)
    {

        $defaultPerPage = 5;

        $perPage = isset($_GET['limit']) ? (int)$_GET['limit'] : $defaultPerPage;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

        $eventModel = new Event;
        $event =  $eventModel->getFirst('id', '=', $id);

        if (!$event) {
            echo "404 NOT FOUND";
            exit;
        }

        $attendeesModel = new Attendee;
        $attendees = $attendeesModel->paginate($perPage, $page, $id);
        $totalAtt = $attendeesModel->count();
        $totalPages = ceil($totalAtt / $perPage);

        $eventModel = new Event;

        $data = [
            'status' => 'success',
            'event' => $event,
            'data' => [
                'attendees' => $attendees,
                'pagination' => [
                    'current_page' => $page,
                    'total_pages' => $totalPages,
                    'per_page' => $perPage,
                    'total_records' => $totalAtt
                ]
            ]
        ];

        return view('pages/events/event_attendee', $data);
    }
}
