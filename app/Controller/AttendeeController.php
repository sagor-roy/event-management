<?php

namespace App\Controller;

use App\Model\Attendee;
use App\Model\Event;

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
            http_response_code(404);
            echo "404 NOT FOUND";
            exit;
        }

        $attendeesModel = new Attendee;
        $attendees = $attendeesModel->paginate($perPage, $page, $id);
        $totalAtt = $attendeesModel->count();
        $totalPages = ceil($totalAtt / $perPage);

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

    public function export(int|string $id)
    {
        $eventModel = new Event;
        $event = $eventModel->getFirst('id', '=', $id);

        if (!$event) {
            http_response_code(404);
            echo "404 NOT FOUND";
            exit;
        }

        $attendeesModel = new Attendee;
        $attendees = $attendeesModel->getAll($id);

        $data = [["ID", "Name", "Email", "Phone", "Registered_Date"]];

        foreach ($attendees as $attendee) {
            $data[] = [
                $attendee['id'],
                $attendee['name'],
                $attendee['email'],
                $attendee['phone'],
                date('M d, Y g:i A', strtotime($attendee['registered_at']))
            ];
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $event['slug'] . '.csv"');

        $output = fopen('php://output', 'w');

        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }
}
