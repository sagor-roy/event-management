<?php

use App\Base\Route;
use App\Controller\HomeController;

Route::get('/', [HomeController::class, 'index']);