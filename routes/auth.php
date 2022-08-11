<?php

use App\Http\Controllers\auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\auth\RegisterUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function(){
// Route Register
Route::get('register',[RegisterUserController::class ,'create'])->name('register');
Route::post('register',[RegisterUserController::class,'store'])->name('valdite_user');

// Login
Route::get('login',[AuthenticatedSessionController::class,'index'])->name('login');
Route::post('login',[AuthenticatedSessionController::class,'valditeUser']);
//  Forgot Password
Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

//  Reset Password
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');

 });


 Route::middleware('auth')->group(function(){

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
    ->name('verification.notice');

Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('verification.send');

Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->name('password.confirm');

Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
 });

 ?>
