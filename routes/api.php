<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::put('/update', [App\Http\Controllers\Api\AuthController::class, 'update'])->middleware('auth:sanctum');
Route::post('/change-password', [App\Http\Controllers\Api\AuthController::class, 'changePassword'])->middleware('auth:sanctum');
Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::post('/news', [App\Http\Controllers\Api\NewsController::class, 'store']);
Route::get('/news', [App\Http\Controllers\Api\NewsController::class, 'index']);
Route::get('/news-updated', [App\Http\Controllers\Api\NewsController::class, 'fetchNews']);
Route::post('/news/favorite', [App\Http\Controllers\Api\NewsController::class, 'addFavorite'])->middleware('auth:sanctum');

Route::post('/favorite-news', [App\Http\Controllers\Api\FavoriteNewsController::class, 'store'])->middleware('auth:sanctum');
Route::get('/favorite-news', [App\Http\Controllers\Api\FavoriteNewsController::class, 'index']);