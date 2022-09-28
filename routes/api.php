<?php

use App\Http\Controllers\BranchOfficeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Category1Controller;
use App\Http\Controllers\Category2Controller;
use App\Http\Controllers\Category3Controller;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistWorkController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DutyStationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ApiController;

use App\Http\Controllers\MyLoginController;
use App\Models\Checklist;
use App\Models\ChecklistWork;

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


Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

// Route::group(['middleware' => 'auth:sanctum'], function(){
// Route::post('/get_checklist_works', [CompanyController::class, 'getChecklistWorks']);
// Route::resource('categories', CategoryController::class);
Route::apiResource('comapnies', CompanyController::class);
Route::apiResource('checklists', ChecklistWorkController::class);
// Route::resource('branchoffice', BranchOfficeController::class);
// Route::resource('dutystation', DutyStationController::class);
// Route::apiResource('category2', Category2Controller::class);
Route::post('/get_category1', [Category1Controller::class, 'getCategory']);
Route::post('/get_category2', [Category2Controller::class, 'getCategory']);
Route::post('/get_checklist', [ChecklistController::class, 'getChecklist']);
Route::post('/get_user', [UserController::class, 'getUser']);
Route::post('/realtime_chk', [ChecklistController::class, 'realtimeCheck']);
// Route::post('/realtime_save', [ChecklistController::class, 'realtime_save']);
Route::post('/realtime_save', [ApiController::class, 'realtime_save']);
Route::post('/login', [ApiController::class, 'login']);
Route::post('/get_checklist_works', [ApiController::class, 'get_checklist_works']);
Route::post('/check_start', [ChecklistController::class, 'checkStart']);
// Route::post('/get_category3', [Category3Controller::class, 'getCategory']);
// Route::post('/get_checklist_works', [ChecklistWorkController::class, 'getChecklist']);
Route::get('/user', function (Request $request) {
    return $request->user();
    });
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
