<?php

namespace App\Controller;

use App\Base\Auth;
use App\Base\Hash;
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

    public function store(): string
    {
        $data = [
            'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
            'email' => isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '',
            'password' => isset($_POST['password']) ? trim($_POST['password']) : '',
            'password_confirmation' => isset($_POST['password_confirmation']) ? trim($_POST['password_confirmation']) : '',
        ];

        $validator = new Validator($data, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            http_response_code(400);
            return json_encode([
                'status' => 'error',
                'message' => "Validation Failed",
                'data' => $validator->errors()
            ]);
        }

        $userModel = new User;
        $existingUser = $userModel->getFirst('email', '=', $data['email']);

        if ($existingUser) {
            http_response_code(409);
            return json_encode([
                'status' => 'error',
                'message' => "This email is already registered.",
                'data' => []
            ]);
        }

        $data['password'] = Hash::make($data['password']);
        unset($data['password_confirmation']);

        $newUser = $userModel->create($data);

        if ($newUser) {
            $user = $userModel->getFirst('email', '=', $data['email']);
            unset($user['password']);
            Auth::login($user);

            http_response_code(200);
            return json_encode([
                'status' => 'success',
                'message' => "Successfully Registered",
                'data' => $user
            ]);
        } else {
            http_response_code(500);
            return json_encode([
                'status' => 'error',
                'message' => "User creation failed.",
                'data' => []
            ]);
        }
    }
}
