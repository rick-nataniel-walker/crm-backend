<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use L5Swagger\Http\Controllers\SwaggerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/api/documentation', [SwaggerController::class, 'api'])->name('l5-swagger.info.docs');

Route::GET("/posts", [PostController::class, "index"]);
Route::GET("/posts/{post}", [PostController::class, "show"]);
Route::POST("/posts", [PostController::class, "store"]);
Route::DELETE("/posts/{post}", [PostController::class, "destroy"]);
Route::POST("/posts/{post}", [PostController::class, "update"]);

Route::GET("/categories", [CategoryController::class, "index"]);
Route::POST("/categories", [CategoryController::class, "store"]);
Route::DELETE("/categories/{category}", [CategoryController::class, "destroy"]);
Route::POST("/categories/{category}", [CategoryController::class, "update"]);

Route::GET("/tags", [TagsController::class, "index"]);
Route::POST("/tags", [TagsController::class, "store"]);
Route::DELETE("/tags/{tag}", [TagsController::class, "destroy"]);
Route::POST("/tags/{tag}", [TagsController::class, "update"]);
