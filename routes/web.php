<?php

use App\Base\Route;
use App\Controller\AttendeeController;
use App\Controller\AuthController;
use App\Controller\DashboardController;
use App\Controller\EventController;
use App\Controller\HomeController;

Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'store']);

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/user/list', [DashboardController::class, 'userList']);
Route::get('/logout', [DashboardController::class, 'logout']);

Route::get('/event/create', [EventController::class, 'index']);
Route::post('/event/store', [EventController::class, 'store']);
Route::get('/event/list', [EventController::class, 'list']);
Route::get('/event/edit/{id}', [EventController::class, 'edit']);
Route::post('/event/update/{id}', [EventController::class, 'update']);
Route::get('/event/delete/{id}', [EventController::class, 'delete']);

Route::get('/event/attendee/{id}', [AttendeeController::class, 'show']);
Route::get('/export/attendee/{id}', [AttendeeController::class, 'export']);