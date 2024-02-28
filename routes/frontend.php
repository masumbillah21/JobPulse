<?php 

use App\Http\Controllers\Frontend\FrontEndController;
use Inertia\Inertia;


Route::get('/', [FrontEndController::class, 'index'])->name('home');

Route::get('/blog', [FrontEndController::class, 'blogPage'])->name('blog');
Route::get('/blog/{slug}', [FrontEndController::class, 'postDetails'])->name('blog.show');
Route::get('/blog/category/{slug}', [FrontEndController::class, 'postCategory'])->name('blog.category');

Route::get('/jobs', [FrontEndController::class, 'jobPage'])->name('job');
Route::get('/job/{slug}', [FrontEndController::class, 'jobDetails'])->name('job.show');

Route::get('/contact', [FrontEndController::class, 'contactPage'])->name('contact');
Route::post('/contact', [FrontEndController::class, 'contactPageEmail'])->name('contact.email');

Route::get('/about', function () {
    return Inertia::render('Frontend/About', [
        'assetsUrl' => asset('assets'),
    ]);
})->name('about');




