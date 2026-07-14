<?php

use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;


Route::prefix('marketing/manager')->middleware(['marketing_manager'])->group(function(){
Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('marketing.dashboard');
    Route::get('manager/logout',[LoginController::class, 'marketingmanagerLogout'])->name('hrmanagerLogout');
});
