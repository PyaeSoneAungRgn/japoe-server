<?php

use App\Http\Controllers\Api\ErrorCaptureController;
use Illuminate\Support\Facades\Route;

Route::post('/capture-error', ErrorCaptureController::class);
