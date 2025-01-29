<?php

use App\Base\Route;
use App\Controller\AuthController;
use App\Controller\HomeController;

Route::get('/login', [AuthController::class, 'index']);
Route::get('/register', [AuthController::class, 'register']);

Route::get('/', [HomeController::class, 'index']);