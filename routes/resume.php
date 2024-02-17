<?php
use App\Http\Controllers\ResumeController;


Route::get('resume/index', [ResumeController::class, 'index'])->name('resume.index');

Route::post('resume/personal-info', [ResumeController::class, 'storePersonalInfo'])->name('resume.storePersonalInfo');
Route::put('resume/personal-info/{id}', [ResumeController::class, 'updatePersonalInfo'])->name('resume.updatePersonalInfo');

Route::post('resume/education', [ResumeController::class, 'saveEducation'])->name('resume.saveEducation');
Route::delete('resume/education/{id}', [ResumeController::class, 'deleteEducation'])->name('resume.deleteEducation');

Route::post('resume/trainig', [ResumeController::class, 'storeTraining'])->name('resume.storeTraining');
Route::put('resume/trainig/{id}', [ResumeController::class, 'updateTraining'])->name('resume.updateTraining');

Route::post('resume/experience', [ResumeController::class, 'storeExperience'])->name('resume.storeExperience');
Route::put('resume/experience/{id}', [ResumeController::class, 'updateExperience'])->name('resume.updateExperience');

Route::post('resume/reference', [ResumeController::class, 'storeReference'])->name('resume.storeReference');
Route::put('resume/reference/{id}', [ResumeController::class, 'updateReference'])->name('resume.updatePersonalInfo');