<?php 

use App\Http\Controllers\Backend\JobController;


Route::resource('jobs', JobController::class);