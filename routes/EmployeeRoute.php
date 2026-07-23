<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\AttendanceInfoController;
use App\Http\Controllers\ChatApp\ChatManagementController;
use App\Http\Controllers\Marketing\MarketingEmployeeController;
use App\Http\Controllers\SalesManagement\BusinessManageController;
use Illuminate\Support\Facades\Route;

Route::prefix('employee')->middleware('employee')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('employee.dashboard');
     Route::get('auther/profile',[AdminController::class, 'autherprofile'])->name('employee.autherprofile');
    Route::get('/task', [EmployeeController::class, 'employeeTask'])->name('employee.task');
    Route::post('/assing/project/status', [EmployeeController::class, 'status'])->name('employee.status');
    Route::get('/logout', [LoginController::class, 'emplogout'])->name('employee.logout');
    Route::get('/attendance', [AttendanceInfoController::class, 'index'])->name('emp.attendance');
    Route::post('/attendance/start-work', [AttendanceInfoController::class, 'startWork'])->name('attendance.start-work');
    Route::post('/attendance/lunch-start', [AttendanceInfoController::class, 'lunchStart'])->name('attendance.lunch-start');
    Route::post('/attendance/lunch-out', [AttendanceInfoController::class, 'lunchOut'])->name('attendance.lunch-out');
    Route::post('/attendance/end-work', [AttendanceInfoController::class, 'endWork'])->name('attendance.end-work');
    Route::get('/attendance/{id}', [AttendanceInfoController::class, 'show'])->name('attendance.show');
    Route::get('/attendance/{id}/edit', [AttendanceInfoController::class, 'edit'])->name('attendance.edit');
    Route::put('/attendance/{id}', [AttendanceInfoController::class, 'update'])->name('attendance.update');
    Route::delete('/attendance/{id}', [AttendanceInfoController::class, 'destroy'])->name('attendance.destroy');
    Route::post('/today/works', [AttendanceInfoController::class, 'TodayWorks'])->name('today.works');
    Route::post('/dailyAttendance', [AttendanceInfoController::class, 'dailyAttendance'])->name('dailyAttendance');
    Route::post('take/leave', [AttendanceInfoController::class, 'TakeLeave'])->name('TakeLeave');

    Route::post('/send/admin/sms', [ChatManagementController::class, 'employeeSms'])->name('employee.chat.sms');
    Route::get('/get/sms', [ChatManagementController::class, 'getSmsEmp'])->name('get.employee.chat');

    Route::controller(MarketingEmployeeController::class)->group(function(){
        Route::get('/mrkempget/task','mrkempgetTask')->name('mrkempgetTask');
    });

//sales Employee

 Route::get('sales/employee/task',[BusinessManageController::class, 'salesEmpTask'])->name('salesEmpTask');
 Route::get('/task/details/{id}/{user_id}',[BusinessManageController::class, 'SalesTaskDetails'])->name('view.sale.task');



});
