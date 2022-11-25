<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\EmployeeStatusController;
use App\Http\Controllers\Api\EmployeeDesignationController;
use App\Http\Controllers\Api\EmployeeDepartmentController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\EmployeeDocumentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login',[AuthController::class,'login']);
Route::middleware('adminAuthentication')->group(function(){
    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('employee-statuses', EmployeeStatusController::class);
    Route::apiResource('employee-designations', EmployeeDesignationController::class);
    Route::apiResource('employee-departments', EmployeeDepartmentController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('employees/{id}/documents', EmployeeDocumentController::class);
});

// Main Things

Route::middleware('auth:api')->group( function () {
   
   Route::post('/logout',[AuthController::class,'logout']);
    
});
