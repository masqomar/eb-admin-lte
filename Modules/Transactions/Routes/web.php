<?php

use Modules\Transactions\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;
app()->make('router')->aliasMiddleware('permisson', \Spatie\Permission\Middlewares\PermissionMiddleware::class);

Route::middleware('auth')->prefix('admin/transactions')->group(function() {
    Route::controller(TransactionsController::class)->group(function () {
        Route::get('/', 'index')->middleware(['permisson:read transactions'])->name('transactions.index');
        Route::post('/', 'store')->middleware(['permisson:create transactions'])->name('transactions.store');
        Route::post('/show', 'show')->middleware(['permisson:read transactions'])->name('transactions.show');
        Route::put('/', 'update')->middleware(['permisson:update transactions'])->name('transactions.update');
        Route::delete('/', 'destroy')->middleware(['permisson:delete transactions'])->name('transactions.destroy');
    });
});
