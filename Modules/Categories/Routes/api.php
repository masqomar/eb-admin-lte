<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/categories', function (Request $request) {
    return $request->user();
});