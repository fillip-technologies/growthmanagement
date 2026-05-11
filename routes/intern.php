<?php

use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\AttendanceInfoController;
use Illuminate\Support\Facades\Route;

Route::prefix('intern')->middleware('intern')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('intern.dashboard');
    Route::get('/task', [InternController::class, 'InternTask'])->name('intern.task');
    Route::post('/assing/project/status', [InternController::class, 'status'])->name('intern.status');
    Route::get('/attendance', [AttendanceInfoController::class, 'attendance'])->name('intern.attendance');
    Route::get('/logout', [LoginController::class, 'internLogout'])->name('intern.logout');
});
