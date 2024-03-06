<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\JobController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\JobCategoryController;


Route::prefix('admin')->name('admin.')->group(function () {

        Route::middleware('guest')->group(function () {
                Route::get('login', [UserController::class, 'create'])
                        ->name('login');
                Route::post('login', [UserController::class, 'store'])->name('admin.login');
        });

        Route::middleware(['auth', 'user.owner'])->group(function () {

                require __DIR__ . '/cache.php';

                Route::get('dashboard', [DashboardController::class, 'indexSystem'])->name('dashboard');
                
                Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
                Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
                Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
                
                
                Route::resource('settings', SettingController::class);
                Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
                Route::resource('tags', TagController::class)->only(['index', 'store', 'destroy']);
                Route::prefix('jobs')->name('jobs.')->group(function () {
                        Route::resource('/categories', JobCategoryController::class)->only(['index', 'store', 'destroy']);
                });
                Route::get('company/{id}', [CompanyController::class, 'changeStatus'])->name('company.status');
                Route::resource('permissions', PermissionController::class);
                Route::resource('roles', RoleController::class);
                Route::get('/jobs/list', [JobController::class, 'jobList'])->name('jobs.list');
                Route::get('/jobs/list/{id}', [JobController::class, 'jobApprove'])->name('jobs.status');
                Route::get('/jobs/single/{id}', [JobController::class, 'singleJobView'])->name('jobs.list.single');
                
                require __DIR__ . '/employee.php';
                require __DIR__ . '/company.php';
                require __DIR__ . '/jobs.php';
                require __DIR__ . '/resume.php';
                require __DIR__ . '/pages.php';
                require __DIR__ . '/blog.php';
                require __DIR__ . '/plugin.php';
        });
});