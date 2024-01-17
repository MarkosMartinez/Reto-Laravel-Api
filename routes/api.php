<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\TiempoActualController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::POST('register', [RegisterController::class, 'register']);
Route::POST('login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::GET('logout', [RegisterController::class, 'logout']);
    Route::GET('logoutall', [RegisterController::class, 'logoutall']);
    Route::GET('tiempo-actual', [TiempoActualController::class, 'obtenerTiempo']);
    
});
Route::POST('comprobar-token', function () {
    return Auth::guard('api')->check() ? true : false;
});