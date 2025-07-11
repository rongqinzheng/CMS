<?php

// 应用工作时间中间件
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Route;

Route::middleware('working.hours')->group(function() {
    Route::post('/leave/apply', [LeaveController::class, 'apply']);
});