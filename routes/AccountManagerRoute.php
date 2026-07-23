<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\SalesManagement\SalesManageController;
use Illuminate\Support\Facades\Route;


Route::prefix('account_manager')->middleware(['account_manager'])->group(function(){
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('acmanager.dashboard');
      Route::controller(SalesManageController::class)->group(function(){
        Route::get('/employees','salesEmployee')->name('sales.employee');
        Route::get('/index','index')->name('index');
        Route::get('/leadedata','leadedata')->name('leadedata');
        Route::get('createleadform','createleadform')->name('createleadform');
        Route::post('/createLeadsdata','createLeadsdata')->name('createLeadsdata');
        Route::get('/projectuser','projectuser')->name('projectuser');
        Route::post('/assingtaskforsales','assingtaskforsales')->name('assingtaskforsales');
        Route::get('/reportforsales','reportforsales')->name('reportforsales');
        Route::get('/viewtaskdetails/{id}/{user_id}','viewtaskdetails')->name('viewtaskdetails');
    });
    Route::get('logout',[LoginController::class, 'acmanagerLogout'])->name('acmanagerLogout');
});
