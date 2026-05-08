<?php

use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;



Route::prefix('intern')->middleware('intern')->group(function(){
 Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('intern.dashboard');
    Route::get('/task',[InternController::class, 'InternTask'])->name('intern.task');
    Route::get('/logout',[LoginController::class, 'internLogout'])->name('intern.logout');
});
