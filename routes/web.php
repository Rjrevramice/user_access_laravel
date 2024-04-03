<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Middleware\CorsMiddleware;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', [ApiController::class, 'login'])->middleware(CorsMiddleware::class);
Route::get('register', [ApiController::class, 'register'])->middleware(CorsMiddleware::class);
Route::get('getUser/{id}', [ApiController::class, 'getUser'])->middleware(CorsMiddleware::class);
Route::get('updateUser/{id}', [ApiController::class, 'updateUser'])->middleware(CorsMiddleware::class);
Route::get('updateUsers/{id}', [ApiController::class, 'updateUsers'])->middleware(CorsMiddleware::class);
Route::get('all-employees', [ApiController::class, 'allEmployees'])->middleware(CorsMiddleware::class);