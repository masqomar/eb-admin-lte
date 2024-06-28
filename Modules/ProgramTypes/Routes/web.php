<?php

use Modules\ProgramTypes\Http\Controllers\ProgramTypesController;
use Illuminate\Support\Facades\Route;
app()->make('router')->aliasMiddleware('permisson', \Spatie\Permission\Middlewares\PermissionMiddleware::class);

Route::middleware('auth')->prefix('admin/program-types')->group(function() {
    Route::controller(ProgramTypesController::class)->group(function () {
        Route::get('/', 'index')->middleware(['permisson:read programtypes'])->name('programtypes.index');
        Route::post('/', 'store')->middleware(['permisson:create programtypes'])->name('programtypes.store');
        Route::post('/show', 'show')->middleware(['permisson:read programtypes'])->name('programtypes.show');
        Route::put('/', 'update')->middleware(['permisson:update programtypes'])->name('programtypes.update');
        Route::delete('/', 'destroy')->middleware(['permisson:delete programtypes'])->name('programtypes.destroy');
    });
});
