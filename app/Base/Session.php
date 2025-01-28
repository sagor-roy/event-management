<?php

namespace App\Base;

class Session
{
    public static function set($type, $message)
    {
        $_SESSION[$type] = $message;
    }

    public static function has($name)
    {
        if (isset($_SESSION[$name])) {
            return true;
        }
    }

    public static function get($name)
    {
        return $_SESSION[$name];
    }
}
