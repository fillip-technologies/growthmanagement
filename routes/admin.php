<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\ManegemantController;
use App\Http\Controllers\Task\DragTaskController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AdminController::class, 'login_admin'])->name('admin');
Route::post('login', [LoginController::class, 'login'])->name('admin.login');
Route::get('admin/store', [LoginController::class, 'store'])->name('login.store');

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::post('/addtotask/{id}',[ProjectController::class, 'addtotask'])->name('addtotask');
    Route::post('/assing/drag/task',[DragTaskController::class, 'assignDragTask'])->name('assignDragTask');
    Route::get('/delete/add/task',[DragTaskController::class, 'deleteAddTask'])->name('deleteAddTask');
     Route::get('/delete/assing/task',[DragTaskController::class, 'assingdeletetask'])->name('assingdeletetask');
    Route::get('/drag/task',[DragTaskController::class, 'dragTask'])->name('drag.task');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('get/all', [ManegemantController::class, 'get_emp'])->name('employees');
    Route::get('create/emp', [ManegemantController::class, 'create'])->name('create');
    Route::get('/emp/{id}', [ManegemantController::class, 'show'])->name('show');
    Route::post('store', [ManegemantController::class, 'store'])->name('add.employees');
    Route::post('/update/employees/{id}', [ManegemantController::class, 'update'])->name('update.employees');
    Route::delete('/employees/{id}', [ManegemantController::class, 'destroy'])->name('destroy');
    Route::post('password/update', [LoginController::class, 'update'])->name('password.updated');
    Route::get('update/password', [LoginController::class, 'update_password'])->name('update.password');
    Route::get('/task/all', [ManegemantController::class, 'task_index'])->name('task');
    Route::get('task/form', [ManegemantController::class, 'task_form'])->name('task.form');
    Route::post('add/task', [ManegemantController::class, 'task_store'])->name('add.task');
    Route::get('/task/{id}/edit', [ManegemantController::class, 'edit_task'])->name('task.edit');
    Route::get('/task/view/{id}', [ManegemantController::class, 'view_task'])->name('task.view');
    Route::post('task/{id}/update', [ManegemantController::class, 'update_task'])->name('tasks.update');
    Route::delete('task/{id}/delete', [ManegemantController::class, 'delete_task'])->name('tasks.delete');
    Route::post('/task/update/store', [ManegemantController::class, 'store_update'])
        ->name('task.update.store');
    Route::get('/getempprefarmans', [ManegemantController::class, 'getempprefarmans'])->name('getempprefarmans');
    Route::get('/project/list', [ProjectController::class, 'index'])->name('project.list');
    Route::get('project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::post('project/store', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::post('project/update/{id}', [ProjectController::class, 'update'])->name('project.update');
    Route::delete('/product/delete/{id}', [ProjectController::class, 'destroy'])->name('project.delete');
    Route::get('/daily-work', [ManegemantController::class, 'daily_works'])->name('daily.work');
    Route::post('/daily-work/store', [ManegemantController::class, 'store_daily_work'])->name('daily.work.store');
    Route::get('/daily-work/edit/{id}', [ManegemantController::class, 'edit_daily_work'])->name('daily.work.edit');
    Route::post('/daily-work/update/{id}', [ManegemantController::class, 'update_daily_work'])->name('daily.work.update');
    Route::post('/module/store', [ManegemantController::class, 'module_store'])
        ->name('module.store');



    Route::get('/weekly/report', [AdminController::class, 'weeklyReport'])->name('week.report');
    Route::get('/get/model',[ProjectController::class, 'getmoduls'])->name('get.module');
Route::get('/all/report',[AdminController::class,'report'])->name('report');
    // reports

    Route::get('report/{id}/user/{uid}', [ManegemantController::class, 'report'])->name('report');
    Route::get('/users', function () {
        return 'This is the admin users list';
    })->name('users');
    Route::get('/settings', function () {
        return 'Admin settings page';
    })->name('settings');
});
