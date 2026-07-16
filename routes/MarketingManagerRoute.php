<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\ManegemantController;
use App\Http\Controllers\Marketing\MarketingEmployeeController;
use App\Http\Controllers\Marketing\MarketingProjectController;
use App\Http\Controllers\Task\DragTaskController;
use Illuminate\Support\Facades\Route;



Route::prefix('marketing/manager')->middleware(['marketing_manager'])->group(function(){
Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('marketing.dashboard');
        Route::get('clientLeads',[AdminController::class, 'clientLeads'])->name('marketing.clientLeads');
        Route::get('/project/list', [ProjectController::class, 'index'])->name('marketing.project.list');
        Route::get('project/create', [ProjectController::class, 'create'])->name('marketing.project.create');
        Route::post('project/store', [ProjectController::class, 'store'])->name('marketing.project.store');
        Route::post('project/update/{id}', [ProjectController::class, 'update'])->name('marketing.project.update');
        Route::get('/project/edit/{id}', [ProjectController::class, 'edit'])->name('marketing.project.edit');
        Route::post('project/update/{id}', [ProjectController::class, 'update'])->name('marketing.project.update');
        Route::delete('/product/delete/{id}', [ProjectController::class, 'destroy'])->name('marketing.project.delete');
        Route::get('/drag/task', [MarketingEmployeeController::class, 'MarketingdragTask'])->name('marketing.drag.task');
        Route::post('/assing/drag/task', [DragTaskController::class, 'assignDragTask'])->name('marketing.assignDragTask');
        Route::get('/delete/assing/task', [DragTaskController::class, 'assingdeletetask'])->name('marketing.assingdeletetask');
      Route::get('members',[MarketingEmployeeController::class, 'teammember'])->name('marketing.teammember');
      Route::get('/emp/{id}', [ManegemantController::class, 'show'])->name('marketing.show');
    Route::post('/update/employees/{id}', [ManegemantController::class, 'update'])->name('marketing.update.employees');

    // Route::controller(MarketingProjectController::class)->group(function(){
    //     Route::get('listproject','listproject')->name('mark.listproject');
    //     Route::get('/projectform','projectform')->name('projectform');
    //     Route::post('/createProject','createProject')->name('mark.createProject');
    //     Route::get('/editproduct/{id}','editproduct')->name('mrk.editproduct');
    //     Route::post('updatdproduct/{id}','updatdproduct')->name('updatdproduct');
    //     Route::delete('/deleteProject/{id}','deleteProject')->name('deleteProject');
    //     Route::get('dragTask','dragTask')->name('mrk.dragTask');
    //     Route::post('assignDragTask','assignDragTask')->name('mrk.assignDragTask');
    // });


    // Route::get('clientLeads',[AdminController::class, 'clientLeads'])->name('marketing.clientLeads');
    // Route::get('manager/logout',[LoginController::class, 'marketingmanagerLogout'])->name('hrmanagerLogout');
});
