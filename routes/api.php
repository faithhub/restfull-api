<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Post Endpoints
Route::get('post', [\App\Http\Controllers\PostController::class, 'index']);
Route::post('post', [\App\Http\Controllers\PostController::class, 'store']);
Route::get('post/{id}', [\App\Http\Controllers\PostController::class, 'show']);
Route::put('post/{id}', [\App\Http\Controllers\PostController::class, 'update']);
Route::delete('post/{id}', [\App\Http\Controllers\PostController::class, 'destroy']);

//Subscribe Endpoint
Route::post('subscribe', [\App\Http\Controllers\SubscriberController::class, 'store']);
Route::get('subscribe', [\App\Http\Controllers\SubscriberController::class, 'index']);

Route::get('mail', [\App\Http\Controllers\MailController::class, 'send_email']);

// Route::get('send-bulk-mail', [SendBulkMailController::class, 'sendBulkMail'])->name('send-bulk-mail');
