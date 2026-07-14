<?php

use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('account_manager')->middleware(['account_manager'])->group(function(){
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('acmanager.dashboard');
    Route::get('logout',[LoginController::class, 'acmanagerLogout'])->name('acmanagerLogout');
});
