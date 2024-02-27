<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\DashboardController;


Route::prefix('admin')->name('admin.')->group(function () {

        Route::middleware('guest')->group(function () {
                Route::get('login', [UserController::class, 'create'])
                        ->name('login');
                Route::post('login', [UserController::class, 'store'])->name('admin.login');
        });

        Route::middleware(['auth', 'user.owner', 'verified'])->group(function () {

                require __DIR__ . '/cache.php';

                Route::get('dashboard', [DashboardController::class, 'indexSystem'])->name('dashboard');
                Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
                Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
                Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
                Route::resource('settings', SettingController::class);

                require __DIR__ . '/employee.php';
                require __DIR__ . '/company.php';
                require __DIR__ . '/permissions.php';
                require __DIR__ . '/jobs.php';
                require __DIR__ . '/resume.php';
                require __DIR__ . '/pages.php';
                require __DIR__ . '/blog.php';
        });
});