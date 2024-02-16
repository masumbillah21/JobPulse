<?php 

use App\Http\Controllers\RoleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

Route::resource('employee', EmployeeController::class);

Route::resource('roles', RoleController::class);