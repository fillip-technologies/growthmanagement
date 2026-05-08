<?php

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;


Route::prefix('employee')->middleware('employee')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('employee.dashboard');

    Route::get('/task', [EmployeeController::class, 'employeeTask'])->name('employee.task');
     Route::post('/assing/project/status',[EmployeeController::class, 'status'])->name('employee.status');
    Route::get('/logout', [LoginController::class, 'internLogout'])->name('employee.logout');

});
