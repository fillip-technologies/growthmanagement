<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\SalesManagement\SalesManageController;
use Illuminate\Support\Facades\Route;


Route::prefix('sales/manager')->middleware(['sales_manager'])->group(function(){
Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('sales_manager.dashboard');
  
    Route::get('/salesmanagerLogout',[LoginController::class, 'salesmanagerLogout'])->name('sales.logout');
});
