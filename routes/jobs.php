<?php 

use App\Http\Controllers\Backend\JobController;


Route::resource('jobs', JobController::class);
Route::get('/candidates', [JobController::class, 'candidateList'])->name('jobs.cadidates.list');
Route::put('/candidates', [JobController::class, 'candidateStatus'])->name('jobs.cadidates.status');
Route::get('/candidate/{id}', [JobController::class, 'candidateSingle'])->name('jobs.cadidate.single');
Route::get('/applications', [JobController::class, 'applicationList'])->name('jobs.applications.list');
Route::get('/application/{id}', [JobController::class, 'applicationList'])->name('jobs.applications.single');