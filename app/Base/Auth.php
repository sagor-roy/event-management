<?php

namespace App\Base;

use App\Model\User;

class Auth
{
    private static $user;

    /**
     * Attempt to authenticate a user using email and password.
     * 
     * @param array $credentials User credentials (email and password)
     * @return bool Returns true if authentication is successful, otherwise false
     */
    public static function attempt(array $credentials): bool
    {
        $email = $credentials['email'];
        $password = $credentials['password'];

        $userModel = new User;
        $user = $userModel->getFirst('email', '=', $email) ?? null;

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            self::login($user);
            return true;
        }

        return false;
    }

    /**
     * Log in a user by storing their data in the session.
     * 
     * @param array $user Authenticated user data
     * @return void
     */
    public static function login($user): void
    {
        $_SESSION['user'] = $user;
        self::$user = $user;
    }

    /**
     * Log out the current user by clearing session data.
     * 
     * @return void
     */
    public static function logout(): void
    {
        unset($_SESSION['user']);
        self::$user = null;
    }

    /**
     * Check if a user is currently authenticated.
     * 
     * @return bool Returns true if a user is logged in, otherwise false
     */
    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Retrieve the authenticated user's data.
     * 
     * @return mixed Returns the authenticated user data or null if no user is logged in
     */
    public static function user(): mixed
    {
        if (!self::$user && isset($_SESSION['user'])) {
            self::$user = $_SESSION['user'];
        }
        return self::$user;
    }
}
