<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProjectController;

Route::prefix('v1')->group(function () {
    Route::get('/projects/{project}', [ProjectController::class, 'show']);
});