<?php

namespace App\Controller;

use App\Base\Auth;
use App\Base\Validator;
use App\Model\Event;

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

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        return view('pages/events/list', $data);
    }

    public function edit($id)
    {
        $eventModel = new Event;
        $event =  $eventModel->getFirst('id', '=', $id);

        if (!$event) {
            echo "404 NOT FOUND";
            exit;
        }

        return view('pages/events/create', [
            'event' => $event,
            'status' => 'edit'
        ]);
    }

    public function update($id)
    {
        $data = [
            'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
            'date' => isset($_POST['date']) ? trim($_POST['date']) : '',
            'location' => isset($_POST['location']) ? trim($_POST['location']) : '',
            'max_capacity' => isset($_POST['max_capacity']) ? trim($_POST['max_capacity']) : '',
            'status' => isset($_POST['status']) ? trim($_POST['status']) : '',
            'description' => isset($_POST['description']) ? trim($_POST['description']) : '',
        ];

        // var_dump($_POST);
        // exit;

        $validator = new Validator($data, [
            'name' => 'required',
            'date' => 'required',
            'location' => 'required',
            'max_capacity' => 'required',
            'status' => 'required|in:0,1',
            'description' => 'required|max:200',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return json_encode([
                'status' => 'error',
                'message' => "Validation Failed",
                'data' => $validator->errors()
            ]);
        }

        $eventModel = new Event();
        $existingEvent = $eventModel->getFirst('slug', '=', generateSlug($data['name']));

        if ($existingEvent && $existingEvent['id'] != $id) {
            http_response_code(400);
            return json_encode([
                'status' => 'error',
                'message' => "Event with this name already exists.",
                'data' => []
            ]);
        }

        $data['slug'] = generateSlug($data['name']);
        $data['date'] = date("Y-m-d H:i:s", strtotime($data['date']));
        $data['created_by'] = Auth::user()['id'];

        if ($eventModel->update($id, $data)) {
            http_response_code(200);
            return json_encode([
                'status' => 'success',
                'message' => "Event updated successfully!",
                'data' => []
            ]);
        } else {
            http_response_code(500);
            return json_encode([
                'status' => 'error',
                'message' => "Event update failed.",
                'data' => []
            ]);
        }
    }


    public function store(): string|false
    {
        $data = [
            'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
            'date' => isset($_POST['date']) ? trim($_POST['date']) : '',
            'location' => isset($_POST['location']) ? trim($_POST['location']) : '',
            'max_capacity' => isset($_POST['max_capacity']) ? trim($_POST['max_capacity']) : '',
            'status' => isset($_POST['status']) ? trim($_POST['status']) : '',
            'description' => isset($_POST['description']) ? trim($_POST['description']) : '',
        ];

        $validator = new Validator($data, [
            'name' => 'required',
            'date' => 'required',
            'location' => 'required',
            'max_capacity' => 'required',
            'status' => 'required|in:0,1',
            'description' => 'required|max:200',
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return json_encode([
                'status' => 'error',
                'message' => "Validation Failed",
                'data' => $validator->errors()
            ]);
        }

        $event = new Event;

        $data['slug'] = generateSlug($data['name']);
        $data['date'] = date("Y-m-d H:i:s", strtotime($data['date']));
        $data['created_by'] = Auth::user()['id'];

        if ($event->create($data)) {
            http_response_code(200);
            return json_encode([
                'status' => 'success',
                'message' => "Event Create Successfully!",
                'data' => []
            ]);
        } else {
            http_response_code(500);
            return json_encode([
                'status' => 'error',
                'message' => "Event creation failed.",
                'data' => []
            ]);
        }
    }
}
