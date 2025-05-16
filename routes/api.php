<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('products', [ProductController::class, 'index'])
    ->middleware('throttle:products');
Route::get("lists/categories", [CategoryController::class, 'list']);


// Route::get("categories", [CategoryController::class, "index"]);
// Route::get("categories/{category}", [CategoryController::class, "show"]);
// Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
// Route::post('categories', [CategoryController::class, 'store']); 
// Route::put('categories/{category}', [CategoryController::class, 'update']);

Route::apiResource("categories", CategoryController::class)->middleware('auth:sanctum');
