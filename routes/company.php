<?php

use App\Http\Controllers\Backend\CompanyController;

Route::resource('company', CompanyController::class)->only([
    'index', 'update', 'store', 'create', 'show'
]);