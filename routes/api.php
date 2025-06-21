<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use L5Swagger\Http\Controllers\SwaggerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::GET("/posts", [PostController::class, "index"]);
Route::POST("/posts", [PostController::class, "store"]);
Route::get('/api/documentation', [SwaggerController::class, 'api'])->name('l5-swagger.info.docs');

Route::GET("/categories", [CategoryController::class, "index"]);
Route::POST("/categories", [CategoryController::class, "store"]);
