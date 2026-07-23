<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\SalesManagement\BusinessManageController;
use App\Http\Controllers\SalesManagement\SalesManageController;
use Illuminate\Support\Facades\Route;


Route::prefix('sales/manager')->middleware(['sales_manager'])->group(function(){
Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('sales_manager.dashboard');
    Route::controller(BusinessManageController::class)->group(function(){
    Route::get('/bda/employees','BDAEmployee')->name('bda.employees');
    Route::get('/mytask','mytask')->name('mytask');
    Route::get('/assingform','assingform')->name('assingform');
    Route::post('/assingtaskforsales','assingtaskforsales')->name('sales.assingtaskforsales');
   });
    Route::get('/salesmanagerLogout',[LoginController::class, 'salesmanagerLogout'])->name('sales.logout');
});
