<?php

use Modules\Students\Http\Controllers\StudentsController;
use Illuminate\Support\Facades\Route;
app()->make('router')->aliasMiddleware('permisson', \Spatie\Permission\Middlewares\PermissionMiddleware::class);

Route::middleware('auth')->prefix('admin/students')->group(function() {
    Route::controller(StudentsController::class)->group(function () {
        Route::get('/', 'index')->middleware(['permisson:read students'])->name('students.index');
        Route::post('/', 'store')->middleware(['permisson:create students'])->name('students.store');
        Route::post('/show', 'show')->middleware(['permisson:read students'])->name('students.show');
        Route::put('/', 'update')->middleware(['permisson:update students'])->name('students.update');
        Route::delete('/', 'destroy')->middleware(['permisson:delete students'])->name('students.destroy');
    });
});
