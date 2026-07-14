<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;



Route::prefix('hr')->middleware(['hr_manager'])->group(function(){
Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('hr.dashboard');
    Route::get('/attendanceList', [AdminController::class, 'attendanceList'])->name('hr.attendanceList');
    Route::get('manager/logout',[LoginController::class, 'hrmanagerLogout'])->name('hrmanagerLogout');
});
