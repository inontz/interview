<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
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
Route::prefix('signup')->group(function () {
    Route::post('/admin', [AuthController::class, 'signupAdmin']);
    Route::post('/editor', [AuthController::class, 'signupEditor']);
    Route::post('/viewer', [AuthController::class, 'signupViewer']);
});

Route::post('/signin', [AuthController::class, 'signin']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/all', function () {
    return ProductResource::collection(Product::all());
});
Route::resource('product', ProductController::class)->middleware('log.route');
