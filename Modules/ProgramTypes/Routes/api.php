<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/programtypes', function (Request $request) {
    return $request->user();
});