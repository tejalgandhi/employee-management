<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//employee route
Route::prefix('employee')->group(function () {
    Route::get('/',[EmployeeController::class, 'index'])->name('employees.index');
    Route::post('employeeAjax', [EmployeeController::class,'employeeAjax'])->name('ajax.employee');
    Route::get('create',[EmployeeController::class, 'create'])->name('employees.create');
    Route::get('{id}/edit', [EmployeeController::class,'edit'])->name('employees.edit');
    Route::post('store',[EmployeeController::class, 'store'])->name('employees.store');
    Route::post('{id}/update', [EmployeeController::class,'update'])->name('employees.update');
    Route::delete('{id}/delete', [EmployeeController::class,'destroy'])->name('employees.destroy');
});
