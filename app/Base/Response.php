<?php

namespace App\Base;

class Response
{
    /**
     * Send a JSON response with optional HTTP status code.
     *
     * @param mixed $data Data to encode as JSON.
     * @param int $statusCode HTTP status code (default: 200).
     * @return string JSON-encoded data (exits after sending).
     */
    public static function json($data, $statusCode = 200)
    {
        header('Content-Type: application/json'); 
        http_response_code($statusCode); 
        return json_encode($data, JSON_PRETTY_PRINT); 
        exit;
    }
}