<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/transactions', function (Request $request) {
    return $request->user();
});