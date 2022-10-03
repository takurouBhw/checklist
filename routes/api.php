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
Route::apiResource('comapnies', CompanyController::class);
Route::apiResource('checklists', ChecklistWorkController::class);
Route::post('/get_category1', [ApiController::class, 'get_category1']);
Route::post('/get_category2', [ApiController::class, 'get_category2']);
Route::post('/get_checklist', [ApiController::class, 'get_checklist']);
Route::post('/get_user', [UserController::class, 'getUser']);
Route::post('/realtime_chk', [ApiController::class, 'realtime_chk']);
Route::post('/check_finish', [ApiController::class, 'check_finish']);

Route::post('/realtime_save', [ApiController::class, 'realtime_save']);
Route::post('/login', [ApiController::class, 'login']);
Route::post('/get_checklist_works', [ApiController::class, 'get_checklist_works']);
Route::post('/check_start', [ApiController::class, 'check_start']);
Route::get('/user', function (Request $request) {
    return $request->user();
    });
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
