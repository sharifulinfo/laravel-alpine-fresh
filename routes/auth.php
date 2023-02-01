<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialLoginController;

use Illuminate\Support\Facades\Route;

Route::controller(SocialLoginController::class)->group(function () {
    Route::get('auth/{driver}', 'redirectToProvider')->name('redirectToProvider');
    Route::get('auth/{driver}/callback', 'handleProviderCallback')->name('handleProviderCallback');
});

Route::controller(AuthController::class)->group(function () {

    Route::get('/', 'login');
    Route::any('login', 'login')->name('login');
    Route::any('signup', 'registration')->name('registration');
    Route::any('reset-password/check-email', 'checkEmail')->name('checkEmail');
    Route::any('reset-password/check-code', 'checkCode')->name('checkCode');
    Route::any('reset-password', 'resetPassword')->name('resetPassword');

    Route::get('logout', 'logout')->name('logout');
});
