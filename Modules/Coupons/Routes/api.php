<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/coupons', function (Request $request) {
    return $request->user();
});