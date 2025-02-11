<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

// storage:link
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'storage:link berhasil dijalankan';
});

// config:cache
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return 'config:cache berhasil dijalankan';
});

// cache:clear
Route::get('/config-clear', function () {
    Artisan::call('config:clear');
    return 'config:clear berhasil dijalankan';
});

// view:clear
Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return 'view:clear berhasil dijalankan';
});

// view:cache
Route::get('/view-cache', function () {
    Artisan::call('view:cache');
    return 'view:cache berhasil dijalankan';
});

// route:clear
Route::get('/route-clear', function () {
    Artisan::call('route:clear');
    return 'route:clear berhasil dijalankan';
});

//route:cache
Route::get('/route-cache', function () {
    Artisan::call('route:cache');
    return 'route:cache berhasil dijalankan';
});
