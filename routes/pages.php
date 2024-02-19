<?php 

use App\Http\Controllers\Backend\PageController;



Route::get('pages/home', [PageController::class, 'showHome'])->name('pages.home');
Route::get('pages/about', [PageController::class, 'showAbout'])->name('pages.about');
Route::get('pages/contact', [PageController::class, 'showContact'])->name('pages.contact');