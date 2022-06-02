<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use App\Models\Employee;
use App\Models\Job;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/jobs', function (){
        return Job::all();
    });

    Route::get('/employees', function (){
        return Employee::all();
    });

    Route::get('/projects', function (){
        return Project::all();
    });

    Route::match(['put', 'patch'],'update/employee/{id}', [EmployeeController::class, 'update']);
    Route::match(['put', 'patch'],'update/job/{id}', [JobController::class, 'update']);

    Route::get('/employee/{employee}/projects', [EmployeeController::class, 'getEmployeeProjects']);
    Route::get('/project/{project}/employees', [EmployeeController::class, 'getProjectEmployees']);
    Route::get('/job/{job}/employees', [EmployeeController::class, 'getJobEmployees']);

    Route::post('/job/add', [JobController::class, 'add']);
    Route::post('/employee/add', [EmployeeController::class, 'add']);
    Route::post('/project/add', [\App\Http\Controllers\ProjectController::class, 'add']);
    Route::post('/employee/project/assign', [\App\Http\Controllers\EmployeeController::class, 'setEmployeesProjects']);
});

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/login', function () {
    return response()->json(['message' => 'Unauthorized please login with post method'],404);
})->name('login');
