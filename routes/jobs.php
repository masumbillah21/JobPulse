<?php 

use App\Http\Controllers\Backend\JobController;
use App\Http\Controllers\Backend\JobCandidateController;



Route::resource('jobs', JobController::class);


Route::get('/candidates', [JobCandidateController::class, 'candidateList'])->name('jobs.cadidates.list');
Route::put('/candidates', [JobCandidateController::class, 'candidateStatus'])->name('jobs.cadidates.status');
Route::get('/candidate/{id}', [JobCandidateController::class, 'candidateSingle'])->name('jobs.cadidate.single');

Route::get('/applications', [JobCandidateController::class, 'applicationList'])->name('jobs.applications.list');
Route::get('/application/{id}', [JobCandidateController::class, 'applicationSingle'])->name('jobs.applications.single');