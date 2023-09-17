<?php

use App\Http\Controllers\AmoAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/getexchanges', [AmoAuthController::class, 'getUpdatesByHook'])->name('api');

//Пробуем api middleware, чтобы избежать аутентификации по csrf-токену