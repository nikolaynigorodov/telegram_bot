<?php

use App\Http\Controllers\TelegramWebHookController;
use App\Http\Controllers\TrelloController;
use Illuminate\Support\Facades\Route;

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

Route::post('/telegram-webhook', TelegramWebHookController::class)
    ->name('telegram.webhook');

Route::post('/trello-webhook', TrelloController::class)
    ->name('trello.webhook');
