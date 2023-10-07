<?php

use App\Http\Controllers\AmoCRM\AmoCrmController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\WebHookLeadUpdatesMiddleware;
use App\Http\Middleware\WebhookMiddleware;

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

Route::post('/getupdates', [AmoCrmController::class, 'getWebHookLeadUpdates'])
                                ->middleware(WebhookMiddleware::class)
                                ->name('getupdates');

                                
Route::post('/getupdates2', [AmoCrmController::class, 'test'])
                                ->name('test');


 