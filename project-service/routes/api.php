<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;

Route::middleware('verify-user')->group(function () {
    Route::apiResource('projects', ProjectController::class);
});
