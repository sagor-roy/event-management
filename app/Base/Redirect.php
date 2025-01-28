<?php

namespace App\Base;

class Redirect
{
    public static function to($path)
    {
        header("Location:{$path}");
    }

    public static function back()
    {
        $previousPage = $_SERVER['HTTP_REFERER'];
        header("Location: $previousPage");
    }
}
