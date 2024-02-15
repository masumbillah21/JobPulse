<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;


Route::prefix('admin')->group(function () {

        Route::middleware('guest')->group(function () {
        Route::get('login', [UserController::class, 'create'])
        ->name('login');

        Route::post('login', [UserController::class, 'store'])->name('admin.login');

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');

        });
    
        Route::middleware(['auth', 'owner'])->group(function () {
                Route::get('verify-email', EmailVerificationPromptController::class)
                        ->name('verification.notice');
        
                Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                        ->middleware(['signed', 'throttle:6,1'])
                        ->name('verification.verify');
        
                Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                        ->middleware('throttle:6,1')
                        ->name('verification.send');
        
                Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                        ->name('password.confirm');
        
                Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
        
                Route::put('password', [PasswordController::class, 'update'])->name('password.update');
        
                Route::post('logout', [UserController::class, 'destroy'])
                        ->name('logout');

                Route::middleware('verified')->group(function () {
                        Route::get('/dashboard', function () {
                                return Inertia::render('Dashboard');
                        })->name('dashboard');
                });

                Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
                Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
                Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

                require __DIR__.'/employee.php';
        });
});