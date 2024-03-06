<?php


use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\DashboardController;


require __DIR__ . '/sys.php';

Route::group(['middleware' => ['auth', 'user']], function () {

    require __DIR__ . '/cache.php';

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    require __DIR__ . '/employee.php';
    require __DIR__ . '/company.php';
    require __DIR__ . '/resume.php';
    require __DIR__ . '/jobs.php';
    require __DIR__ . '/blog.php';
    require __DIR__ . '/plugin.php';

    Route::post('logout', [UserController::class, 'destroy'])->name('logout');
});

Route::get('set-password', function(){
    User::find(3)->update(['password' => Hash::make('12345678')]);
});

require __DIR__ . '/auth.php';

require __DIR__ . '/frontend.php';