<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/unauthenticated', function (Request $request) {});

Route::controller(\App\Http\Controllers\AuthController::class)->middleware('guest')->group(function () {
   Route::post('/login', 'login');
   Route::delete('/logout', 'logout');
});

Route::controller(\App\Http\Controllers\BookController::class)->middleware('auth:api')->group(function () {
    Route::get('/books', 'index');
    Route::get('/books/{book}', 'show');
    Route::post('/books', 'store');
    Route::put('/books/{book}', 'update');
    Route::delete('/books/{book}', 'destroy');
});
