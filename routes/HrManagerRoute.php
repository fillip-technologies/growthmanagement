<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\AttendanceInfoController;
use App\Http\Controllers\TeamHead\TeamHaedController;
use Illuminate\Support\Facades\Route;


Route::prefix('hr')->middleware(['hr_manager'])->group(function(){
Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('hr.dashboard');
    Route::get('/attendance/export', [AdminController::class, 'export'])->name('hr.attendance.export');
    Route::get('/attendance/list', [AdminController::class, 'attendanceList'])->name('hr.attendance.list');
    Route::get('project/information/{id}',[TeamHaedController::class, 'projectInfo'])->name('hr.project.info');
    Route::get('/attendanceList', [AdminController::class, 'attendanceList'])->name('hr.attendanceList');
    Route::get('/leave/live', [AdminController::class, 'leaveLive'])->name('hr.leaveList');
    Route::get('manager/logout',[LoginController::class, 'hrmanagerLogout'])->name('hrmanagerLogout');


    Route::get('viwe/leave', [AttendanceInfoController::class, 'ViewLeave'])->name('hr.viwe.leave');
    Route::post('/leave/approved', [AttendanceInfoController::class, 'statusApproved'])->name('hr.status.approved');
    Route::post('/leave/reject', [AttendanceInfoController::class, 'statusReject'])->name('hr.status.reject');
    Route::delete('/leave/delete', [AttendanceInfoController::class, 'statusDelete'])->name('hr.status.delete');
});
