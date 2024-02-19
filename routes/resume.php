<?php

use App\Http\Controllers\Backend\ResumeController;



Route::get('resume/index', [ResumeController::class, 'index'])->name('resume.index');

Route::post('resume/personal-info', [ResumeController::class, 'storePersonalInfo'])->name('resume.storePersonalInfo');
Route::put('resume/personal-info/{id}', [ResumeController::class, 'updatePersonalInfo'])->name('resume.updatePersonalInfo');

Route::post('resume/education', [ResumeController::class, 'saveEducation'])->name('resume.saveEducation');
Route::delete('resume/education/{id}', [ResumeController::class, 'deleteEducation'])->name('resume.deleteEducation');

Route::post('resume/trainig', [ResumeController::class, 'saveTraining'])->name('resume.saveTraining');
Route::delete('resume/trainig/{id}', [ResumeController::class, 'deleteTraining'])->name('resume.deleteTraining');

Route::post('resume/experience', [ResumeController::class, 'saveExperience'])->name('resume.saveExperience');
Route::delete('resume/experience/{id}', [ResumeController::class, 'deleteExperience'])->name('resume.deleteExperience');

Route::post('resume/reference', [ResumeController::class, 'saveReference'])->name('resume.saveReference');
Route::delete('resume/reference/{id}', [ResumeController::class, 'deleteReference'])->name('resume.deleteReference');