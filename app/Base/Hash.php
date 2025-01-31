<?php

namespace App\Base;

class Hash
{
    /**
     * Hash a password using the default algorithm.
     *
     * @param string $password The plain text password to be hashed
     * @return string The hashed password
     */
    public static function make($password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
