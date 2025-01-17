<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/admin');
    } else {
        return redirect('/login');
    }
});

//Route Matches Register
Route::match(['get', 'post'], '/register', function () {
    return redirect('/login');
});

Auth::routes(['register' => false]);

Route::name('admin.')->prefix('admin')->group(function () {
    Route::middleware('isAdmin')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
        Route::resource('product.gallery', App\Http\Controllers\Admin\ProductGalleryController::class)->only([
            'index', 'create', 'store', 'destroy'
        ]);
    });
});
