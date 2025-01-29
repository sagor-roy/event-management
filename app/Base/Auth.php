<?php

namespace App\Base;

use App\Model\User;

class Auth
{
    private static $user;

    public static function attempt(array $credentials): bool
    {
        $email = $credentials['email'];
        $password = $credentials['password'];

        $userModel = new User;
        $user = $userModel->where('email', '=', $email)->get()[0] ?? null;

        if ($user && password_verify($password, $user['password'])) {
            self::login($user);
            return true;
        }

        return false;
    }

    // Login function

    public static function login($user) : void
    {
        $_SESSION['user'] = $user;
        self::$user = $user;
    }

    // Logout function
    public static function logout(): void
    {
        unset($_SESSION['user']);
        self::$user = null;
    }

    // Check if user is authenticated
    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    // Get the authenticated user
    public static function user() : mixed
    {
        if (!self::$user && isset($_SESSION['user'])) {
            self::$user = $_SESSION['user'];
        }
        return self::$user;
    }
}
