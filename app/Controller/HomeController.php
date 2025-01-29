<?php

namespace App\Controller;

use App\Base\Auth;
use App\Base\Redirect;
use App\Model\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        Redirect::to('/login');
    }

    public function userList()
    {
        $defaultPerPage = 5;

        $perPage = isset($_GET['limit']) ? (int)$_GET['limit'] : $defaultPerPage;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

        $userModel = new User;
        $users = $userModel->paginate($perPage, $page);
        $totalUsers = $userModel->count();
        $totalPages = ceil($totalUsers / $perPage);

        $data = [
            'status' => 'success',
            'data' => [
                'users' => $users,
                'pagination' => [
                    'current_page' => $page,
                    'total_pages' => $totalPages,
                    'per_page' => $perPage,
                    'total_records' => $totalUsers
                ]
            ]
        ];

        return view('pages/users/list', $data);
    }
}
