<?php

use App\Http\Controllers\Api\Chat\ChatBoxController;
use App\Http\Controllers\Api\Chat\ChatListController;
use App\Http\Controllers\Api\Chat\MessageController;
use App\Http\Controllers\Api\Public\Auth\AuthController;
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

Route::group(['prefix' => "public"],function(){
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
});

Route::group(['prefix' => "chat", "middleware" => "authCheck"],function(){
    Route::post('start',[MessageController::class,'startChat']);
    Route::get('chat-list',[ChatListController::class,'allConvesation']);
    Route::get('chat-box/{conversation_id}',[ChatBoxController::class,'chatBox']);
});
