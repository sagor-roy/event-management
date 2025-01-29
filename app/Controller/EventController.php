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
        return view('pages/events/list');
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
            'status' => 'required',
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
                'message' => "Event Create Success!",
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
