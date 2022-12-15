<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;



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

Route::middleware('auth:sanctum')->get('/users', [ChatController::class, 'getUsers']);
// Route::group(['middleware' => ['auth:sanctum']], get('/users', ChatController::class, 'getUsers'));


Route::group(['middleware' =>['auth:sanctum']] , function () {


//create a chat

Route::post('/chat', [ChatController::class, 'create']);

//getting all of our chat

Route::get('/chat', [ChatController::class, 'index']);

//sending a message

Route::post('/chat/{id}/send', [ChatController::class, 'sendMessage']);

//getting all of the messages within a chat

Route::get('/chat/{id}/messages', [ChatController::class, 'show']);


});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);


