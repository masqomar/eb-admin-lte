<?php

use Modules\Programs\Http\Controllers\ProgramsController;
use Illuminate\Support\Facades\Route;
app()->make('router')->aliasMiddleware('permisson', \Spatie\Permission\Middlewares\PermissionMiddleware::class);

Route::middleware('auth')->prefix('admin/programs')->group(function() {
    Route::controller(ProgramsController::class)->group(function () {
        Route::get('/', 'index')->middleware(['permisson:read programs'])->name('programs.index');
        Route::post('/', 'store')->middleware(['permisson:create programs'])->name('programs.store');
        Route::post('/show', 'show')->middleware(['permisson:read programs'])->name('programs.show');
        Route::put('/', 'update')->middleware(['permisson:update programs'])->name('programs.update');
        Route::delete('/', 'destroy')->middleware(['permisson:delete programs'])->name('programs.destroy');
    });
});
