<?php 

use Inertia\Inertia;
use App\Http\Controllers\Frontend\JobPageController;
use App\Http\Controllers\Frontend\BlogPageController;


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

Route::get('/jobs', [JobPageController::class, 'index'])->name('job');
Route::get('/job/{id}', [JobPageController::class, 'jobDetails'])->name('job.show');


Route::get('/blog', [BlogPageController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogPageController::class, 'postDetails'])->name('blog.show');

Route::get('/contact', function () {
    return Inertia::render('Frontend/Contact', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'assetsUrl' => asset('assets'),
    ]);
})->name('contact');