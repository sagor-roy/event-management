<?php

use App\Base\Route;
use App\Controller\AuthController;
use App\Controller\EventController;
use App\Controller\HomeController;

Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'store']);

Route::get('/', [HomeController::class, 'index']);
Route::get('/logout', [HomeController::class, 'logout']);

Route::get('/event/create', [EventController::class, 'index']);