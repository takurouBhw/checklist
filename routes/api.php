<?php

use App\Http\Controllers\BranchOfficeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DutyStationController;
use App\Models\Category;

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

Route::resource('users', UserController::class);
Route::resource('categories', CategoryController::class);
Route::resource('comapnies', CompanyController::class);
Route::resource('branchoffice', BranchOfficeController::class);
Route::resource('dutystation', DutyStationController::class);
Route::resource('checklist', ChecklistController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
