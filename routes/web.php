<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;


if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}


Route::get('/', [EmployeeController::class, 'index']);
Route::get('/get-employee', [EmployeeController::class, 'getEmployee']);
Route::post('/employee', [EmployeeController::class, 'addEmployee']);
Route::get('/get-employee/{id}', [EmployeeController::class, 'getEmployeeById']); 
Route::put('/update-employee/{id}', [EmployeeController::class, 'updateEmployeeById']);
Route::delete('/delete-employee/{id}', [EmployeeController::class, 'deleteEmployeeById']);