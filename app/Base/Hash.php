<?php

namespace App\Base;

class Hash
{
    public static function make($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
