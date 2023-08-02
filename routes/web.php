<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Chat\CreateChat;
use App\Http\Livewire\Chat\Main;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',function (){
    return view('Dashboard.index');
})->middleware('auth');

Route::group(['prefix' => 'chat','middleware' => 'auth'],function(){
    Route::get('all-User',CreateChat::class)->name('all_user');
    Route::get('recent',Main::class)->name('recent.conversation');
});

require __DIR__.'/auth.php';
