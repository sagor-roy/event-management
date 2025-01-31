<?php

namespace App\Base;

class Session
{
    /**
     * Store a value in the session.
     *
     * @param string $type The session key
     * @param mixed $message The value to store in the session
     * @return void
     */
    public static function set($type, $message): void
    {
        $_SESSION[$type] = $message;
    }

    /**
     * Check if a session key exists.
     *
     * @param string $name The session key to check
     * @return bool True if the key exists, false otherwise
     */
    public static function has($name): bool
    {
        return isset($_SESSION[$name]);
    }

    /**
     * Retrieve a value from the session.
     *
     * @param string $name The session key
     * @return mixed The stored value or null if not found
     */
    public static function get($name)
    {
        return $_SESSION[$name] ?? null;
    }
}
