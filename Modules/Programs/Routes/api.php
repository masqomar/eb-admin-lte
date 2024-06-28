<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/programs', function (Request $request) {
    return $request->user();
});