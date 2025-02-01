<?php

use App\Base\Route;

error_reporting(E_ALL);

date_default_timezone_set('Asia/Dhaka');

define('BASE_PATH', __DIR__ . '/../');
define('VIEWS_PATH', BASE_PATH . 'views/');
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);

require BASE_PATH . 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

if ($_ENV['APP_ENV'] === 'production') {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', BASE_PATH . 'logs/error.log');
} else {
    ini_set('display_errors', 1);
    ini_set('error_log', BASE_PATH . 'logs/error.log');
}


require_once BASE_PATH . 'routes/web.php';

Route::handleRequest();
