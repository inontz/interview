<?php

use App\Http\Controllers\OAuthController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(OAuthController::class)->group(function () {
    Route::get('auth/{provider}', 'redirectToProvider')->name('auth.oauth');
    Route::get('auth/{provider}/callback', 'handleProviderCallback');
});
