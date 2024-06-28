<?php

use Modules\Categories\Http\Controllers\CategoriesController;
use Illuminate\Support\Facades\Route;
app()->make('router')->aliasMiddleware('permisson', \Spatie\Permission\Middlewares\PermissionMiddleware::class);

Route::middleware('auth')->prefix('admin/categories')->group(function() {
    Route::controller(CategoriesController::class)->group(function () {
        Route::get('/', 'index')->middleware(['permisson:read categories'])->name('categories.index');
        Route::post('/', 'store')->middleware(['permisson:create categories'])->name('categories.store');
        Route::post('/show', 'show')->middleware(['permisson:read categories'])->name('categories.show');
        Route::put('/', 'update')->middleware(['permisson:update categories'])->name('categories.update');
        Route::delete('/', 'destroy')->middleware(['permisson:delete categories'])->name('categories.destroy');
    });
});
