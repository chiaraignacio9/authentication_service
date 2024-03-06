<?php

use App\libs\Route;
use App\presentation\controllers\DashboardController;
use App\presentation\controllers\LoginController;
use App\presentation\controllers\LogoutController;
use App\presentation\controllers\RegisterController;

require_once dirname(__DIR__) . '/libs/Route.php';
session_start();

Route::post('/auth/login', [LoginController::class, 'index']);

Route::post('/auth/logout', [LogoutController::class, 'index']);

Route::post('auth/register', [RegisterController::class, 'index']);

Route::dispatch();