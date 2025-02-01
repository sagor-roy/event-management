<?php

namespace App\Controller;

use App\Base\Auth;
use App\Base\Redirect;
use App\Model\Event;
use App\Model\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $eventModel = new Event;
        $adminModel = new User;

        $total_event = $eventModel->count();
        $total_active_event = $eventModel->count('1');
        $total_inactive_event = $eventModel->count('0');
        $total_admin = $adminModel->count();

        return view(
            'pages/dashboard',
            [
                'total_event' => $total_event,
                'total_active_event' => $total_active_event,
                'total_inactive_event' => $total_inactive_event,
                'total_admin' => $total_admin
            ]
        );
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
