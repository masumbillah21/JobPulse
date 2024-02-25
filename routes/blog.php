<?php 
use App\Http\Controllers\Backend\BlogController;

Route::resource('blogs', BlogController::class);
Route::get('categories', [BlogController::class, 'categories'])->name('blogs.categories');