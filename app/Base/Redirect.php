<?php

namespace App\Base;

class Redirect
{
    /**
     * Redirect the user to a specified path.
     *
     * @param string $path The URL or relative path to redirect to
     * @return void
     */
    public static function to($path): void
    {
        header("Location: {$path}");
        exit;
    }

    /**
     * Redirect the user back to the previous page.
     *
     * @return void
     */
    public static function back(): void
    {
        $previousPage = $_SERVER['HTTP_REFERER'] ?? '/'; 
        header("Location: $previousPage");
        exit; 
    }
}
