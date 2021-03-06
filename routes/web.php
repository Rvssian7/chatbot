<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/botman', 'ChatBotController@handle');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/chat',[ConversationController::class,'chatIndex'])->name('conversation.chat');
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::resource('conversation', 'ConversationController');
    Route::get('conversation/change/{id}/{estado}',[ConversationController::class,'changeStatus'])->name('conversation.finalizar');
});
