<?php

use App\Http\Controllers\BranchOfficeController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoController;

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
Route::apiResource('task', TaskController::class);
// Route::get('/user', function (Request $request) {
//     return $request->user();
// });
Route::apiResource('task', TaskController::class);
Route::apiResource('todo', TodoController::class);
Route::apiResource('category', CategoryController::class);

// Route::group(['middleware' => 'auth:sanctum'], function () {
//     Route::apiResource('task', TaskController::class);
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
