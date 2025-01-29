<?php

use App\Base\Route;

error_reporting(E_ALL);

// Define paths
define('BASE_PATH', __DIR__ . '/../');
define('VIEWS_PATH', BASE_PATH . 'views/');
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);

// Composer autoload
require BASE_PATH . 'vendor/autoload.php';

// Load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Set error reporting based on environment
if ($_ENV['APP_ENV'] === 'production') {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', BASE_PATH . 'logs/error.log');
} else {
    ini_set('display_errors', 1);
}


// Include routes
require_once BASE_PATH . 'routes/web.php';

// Handle the incoming request
Route::handleRequest();
