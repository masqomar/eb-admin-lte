<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/students', function (Request $request) {
    return $request->user();
});