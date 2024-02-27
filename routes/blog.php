<?php 
use App\Http\Controllers\Backend\BlogController;

Route::resource('blogs', BlogController::class);