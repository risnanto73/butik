<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('categories', [\App\Http\Controllers\API\FrontEndController::class, 'category']);
Route::get('categories/{slug}', [\App\Http\Controllers\API\FrontEndController::class, 'categoryDetail']);
Route::get('products', [\App\Http\Controllers\API\FrontEndController::class, 'product']);
Route::get('products/{slug}', [\App\Http\Controllers\API\FrontEndController::class, 'productDetail']);
Route::get('products/{id}/gallery', [\App\Http\Controllers\API\FrontEndController::class, 'productGallery']);
