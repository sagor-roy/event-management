<?php

namespace App\Controller;

use App\Base\Validator;
use App\Model\Attendee;
use App\Model\Event;
use DateTime;

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
            abort_404();
            exit;
        }

        $data = [
            'event' => $event
        ];

        return view('frontend/details', $data);
    }

    public function store(string|int $event_id)
    {
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
        ];

        $validator = $this->validateInput($data);

        if ($validator->fails()) {
            http_response_code(400);
            return json_encode([
                'status' => 'error',
                'message' => "Validation Failed",
                'data' => $validator->errors()
            ]);
        }

        // Check event capacity
        $eventModel = new Event;
        $event = $eventModel->checkCapacity($event_id);
        if (!$this->isEventValid($event)) {
            http_response_code(400);
            return json_encode([
                'status' => 'error',
                'message' => "Event not found or registration closed or sit stockout",
                'data' => []
            ]);
        }

        // Check for duplicate registration
        $attendeModel = new Attendee;

        if ($attendeModel->isPhoneRegistered($event_id, $data['phone'])) {
            http_response_code(400);
            return json_encode([
                'status' => 'error',
                'message' => "This phone is already registered for this event!",
                'data' => []
            ]);
        }

        // Create attendee record
        $data['event_id'] = $event_id;
        if ($attendeModel->create($data)) {
            http_response_code(200);
            return json_encode([
                'status' => 'success',
                'message' => "Registration Successful!",
                'data' => []
            ]);
        } else {
            http_response_code(500);
            return json_encode([
                'status' => 'error',
                'message' => "Registration Failed!",
                'data' => []
            ]);
        }
    }

    private function validateInput(array $data): Validator
    {
        $validator = new Validator($data, [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required|max:11'
        ]);
        return $validator;
    }

    private function isEventValid($event): bool
    {
        return $event && $event['remaining_tickets'] > 0 && new DateTime() <= new DateTime($event['date']);
    }
}
