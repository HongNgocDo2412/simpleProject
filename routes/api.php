<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Company\Controllers\CompanyController;
use App\Modules\Employee\Controllers\EmployeeController;
use App\Modules\User\Controllers\UserController;
//use App\Http\Controllers\API\AuthController;

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

Route::prefix('v1')->group(function (){
    Route::prefix('user')->group(function (){
        Route::post('/login', [UserController::class, 'login']);
        Route::post('/register', [UserController::class, 'register']);    
    });
    
    Route::middleware('auth:api')->group(function (){
       
            Route::get('/getUser', [UserController::class, 'getCurrentUser']);  

            Route::prefix('company')->group(function (){
                Route::get('/',[CompanyController::class,'getAll']);
                Route::post('/create',[CompanyController::class,'create']);
                Route::get('/{id}',[CompanyController::class,'show']);
                Route::put('/{id}',[CompanyController::class,'update']);
                Route::delete('/{id}',[CompanyController::class,'destroy']);
                
            });
        
            Route::prefix('employee')->group(function (){
                Route::get('/',[EmployeeController::class,'getAll']);
                Route::post('/create',[EmployeeController::class,'create']);
                Route::get('/{id}',[EmployeeController::class,'show']);
                Route::put('/{id}',[EmployeeController::class,'update']);
                Route::delete('/{id}',[EmployeeController::class,'destroy']);
                Route::get('/company/{company_id}',[EmployeeController::class,'getEmployeeList']);
            }); 
     });
});

