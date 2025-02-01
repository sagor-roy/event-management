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

        $defaultPerPage = 6;
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

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

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
            'g-recaptcha-response' => isset($_POST['g-recaptcha-response']) ? trim($_POST['g-recaptcha-response']) : '',
        ];

        $validator = $this->validateInput($data);

        if ($validator->fails()) {
            http_response_code(400);
            return json_encode([
                'status' => 'error',
                'message' => "Please check your input fields.",
                'data' => $validator->errors()
            ]);
        }

        if (env('CAPTCHA_VISIBLE') == 'true') {
            if (!$this->recaptcha_check($data['g-recaptcha-response'])) {
                http_response_code(400);
                return json_encode([
                    'status' => 'error',
                    'message' => "Invalid Captcha.",
                    'data' => $validator->errors()
                ]);
            }
        }

        // Check event capacity
        $eventModel = new Event;
        $event = $eventModel->checkCapacity($event_id);
        if (!$this->isEventValid($event)) {
            http_response_code(400);
            return json_encode([
                'status' => 'error',
                'message' => "Event registration closed or sit stockout",
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
            'phone' => 'required|max:11|min:11'
        ]);
        return $validator;
    }

    private function isEventValid($event): bool
    {
        return $event && $event['remaining_tickets'] > 0 && new DateTime() <= new DateTime($event['date']);
    }


    private function recaptcha_check($response)
    {
        $post_data                          = array();
        $post_data['secret']                = env('CAPTCHA_SECRET');
        $post_data['response']              = $response;

        foreach ($post_data as $key => $value)   $post_items[] = $key . '=' . $value;
        $post_string = implode('&', $post_items);

        $ch = curl_init("https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, count($post_data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $content = curl_exec($ch);
        curl_close($ch);

        $ret_val = json_decode($content);

        return $ret_val->success;
    }
}
