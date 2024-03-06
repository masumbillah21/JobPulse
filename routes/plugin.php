<?php
use App\Http\Controllers\Backend\FeatureController;

Route::resource('plugins', FeatureController::class)->except('show');

Route::post('plugins/{id}/active-deactive', [FeatureController::class, 'activeDeactive'])->name('plugins.active-deactive');