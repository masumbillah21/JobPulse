<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//create a route to clear all cache
Route::get('/cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    return redirect()->back()->with('message', 'Cache cleared successfully');
})->name('cache.clear');

Route::get('/', function () {
    return Inertia::render('Frontend/Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'assetsUrl' => asset('assets'),
    ]);
})->name('home');


Route::get('/about', function () {
    return Inertia::render('Frontend/About', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'assetsUrl' => asset('assets'),
    ]);
})->name('about');

Route::get('/job', function () {
    return Inertia::render('Frontend/Job', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'assetsUrl' => asset('assets'),
    ]);
})->name('job');


Route::get('/blog', function () {
    return Inertia::render('Frontend/Blog', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'assetsUrl' => asset('assets'),
    ]);
})->name('blog');

Route::get('/contact', function () {
    return Inertia::render('Frontend/Contact', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'assetsUrl' => asset('assets'),
    ]);
})->name('contact');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/sys.php';
require __DIR__.'/auth.php';