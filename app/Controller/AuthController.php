<?php

namespace App\Controller;

use App\Base\Auth;
use App\Base\Redirect;
use App\Base\Session;
use App\Base\Validator;
use App\Model\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function login(): string | false
    {
        $data = [
            'email' => isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '',
            'password' => isset($_POST['password']) ? trim($_POST['password']) : ''
        ];

        $validator = new Validator($data, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return json_encode([
                'status' => 'error',
                'message' => "Validation Faild",
                'data' => $validator->errors()
            ]);
        }

        if (Auth::attempt($data)) {
            http_response_code(200);
            return json_encode([
                'status' => 'success',
                'message' => "Successfully Login!",
                'data' => []
            ]);
        } else {
            http_response_code(419);
            return json_encode([
                'status' => 'error',
                'message' => "Invalid email or password.",
                'data' => []
            ]);
        }
    }
}
