<?php 

use App\Http\Controllers\Frontend\FrontEndController;
use Inertia\Inertia;


Route::get('/', [FrontEndController::class, 'index'])->name('home');

Route::get('/blog', [FrontEndController::class, 'blogPage'])->name('blog');
Route::get('/blog/{slug}', [FrontEndController::class, 'postDetails'])->name('blog.show');
Route::get('/blog/category/{slug}', [FrontEndController::class, 'postCategory'])->name('blog.category');

Route::get('/job', [FrontEndController::class, 'jobPage'])->name('job');
Route::get('/job/{slug}', [FrontEndController::class, 'jobDetails'])->name('job.show');
Route::post('/job/apply/', [FrontEndController::class, 'applyJob'])->name('job.apply');

Route::get('/contact', [FrontEndController::class, 'contactPage'])->name('contact');
Route::post('/contact', [FrontEndController::class, 'contactPageEmail'])->name('contact.email');

Route::get('/{slug}', [FrontEndController::class, 'generalPages'])->name('public.page');




