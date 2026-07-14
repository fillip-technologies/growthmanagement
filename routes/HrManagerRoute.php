<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\TeamHead\TeamHaedController;
use Illuminate\Support\Facades\Route;




Route::prefix('hr')->middleware(['hr_manager'])->group(function(){
Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('hr.dashboard');
    Route::get('project/information/{id}',[TeamHaedController::class, 'projectInfo'])->name('hr.project.info');
    Route::get('/attendanceList', [AdminController::class, 'attendanceList'])->name('hr.attendanceList');
    Route::get('/leave/live', [AdminController::class, 'leaveLive'])->name('hr.leaveList');
    Route::get('manager/logout',[LoginController::class, 'hrmanagerLogout'])->name('hrmanagerLogout');
});
