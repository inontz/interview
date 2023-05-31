<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\AuthController;
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
Route::prefix('register')->group(function () {
    Route::post('/admin', [AuthController::class, 'register_admin']);
    Route::post('/editor', [AuthController::class, 'register_editor']);
    Route::post('/viewer', [AuthController::class, 'register_viewer']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'log.route'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('product', ProductController::class);
    Route::apiResource('order', OrderController::class);
});
