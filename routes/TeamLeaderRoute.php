<?php

use App\Http\Controllers\TeamHead\TeamHaedController;
use Illuminate\Support\Facades\Route;



Route::prefix('teamhead')->middleware(['team_leader'])->group(function(){
Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('teamhead.dashboard');
Route::get('members',[TeamHaedController::class, 'teammember'])->name('teammember');
    Route::get('/teamhead/logout',[TeamHaedController::class, 'teamheadlogout'])->name('teamhead.logout');
});
