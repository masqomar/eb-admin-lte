<?php

use Modules\Coupons\Http\Controllers\CouponsController;
use Illuminate\Support\Facades\Route;
app()->make('router')->aliasMiddleware('permisson', \Spatie\Permission\Middlewares\PermissionMiddleware::class);

Route::middleware('auth')->prefix('admin/coupons')->group(function() {
    Route::controller(CouponsController::class)->group(function () {
        Route::get('/', 'index')->middleware(['permisson:read coupons'])->name('coupons.index');
        Route::get('/create', 'create')->middleware(['permisson:create coupons'])->name('coupons.create');
        Route::post('/', 'store')->middleware(['permisson:create coupons'])->name('coupons.store');
        Route::get('/edit/{id}', 'edit')->middleware(['permisson:read coupons'])->name('coupons.edit');
        Route::put('/', 'update')->middleware(['permisson:update coupons'])->name('coupons.update');
        Route::delete('/', 'destroy')->middleware(['permisson:delete coupons'])->name('coupons.destroy');
    });
});
