<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;



Route::controller(AdminController::class)->group(function () {
    Route::get('dashboard', 'dashboard')->name('adminDashboard');
    Route::post('get-users', 'getUsers')->name('getUsers');
});
