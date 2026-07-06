<?php

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Task\DragTaskController;
use App\Http\Controllers\TeamHead\TeamHaedController;
use Illuminate\Support\Facades\Route;





Route::prefix('teamhead')->middleware(['team_leader'])->group(function(){
Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('teamhead.dashboard');
Route::get('members',[TeamHaedController::class, 'teammember'])->name('teammember');
Route::get('/task', [EmployeeController::class, 'employeeTask'])->name('teamhead.employee.task');
Route::get('/drag/task', [TeamHaedController::class, 'TeamheaddragTask'])->name('teamhead.drag.task');
Route::get('/delete/assing/task', [DragTaskController::class, 'assingdeletetask'])->name('teamhead.assingdeletetask');
 Route::get('/all/report', [TeamHaedController::class, 'Teamheadreport'])->name('teamhead.report');
Route::post('/assing/drag/task', [DragTaskController::class, 'assignDragTask'])->name('teamhead.assignDragTask');
Route::get('/teamhead/logout',[TeamHaedController::class, 'teamheadlogout'])->name('teamhead.logout');
});
