<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Marketing\MarketingProjectController;
use Illuminate\Support\Facades\Route;




Route::prefix('marketing/manager')->middleware(['marketing_manager'])->group(function(){
Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('marketing.dashboard');
    Route::controller(MarketingProjectController::class)->group(function(){
        Route::get('listproject','listproject')->name('mark.listproject');
        Route::get('/projectform','projectform')->name('projectform');
        Route::post('/createProject','createProject')->name('mark.createProject');
        Route::get('/editproduct/{id}','editproduct')->name('mrk.editproduct');
        Route::post('updatdproduct/{id}','updatdproduct')->name('updatdproduct');
        Route::delete('/deleteProject/{id}','deleteProject')->name('deleteProject');
    });
    Route::get('clientLeads',[AdminController::class, 'clientLeads'])->name('marketing.clientLeads');
    Route::get('manager/logout',[LoginController::class, 'marketingmanagerLogout'])->name('hrmanagerLogout');
});
