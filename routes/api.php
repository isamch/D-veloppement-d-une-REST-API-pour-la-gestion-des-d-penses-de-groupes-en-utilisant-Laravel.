<?php

use App\Http\Controllers\Api_v1\Auth\loginController;
use App\Http\Controllers\Api_v1\Auth\RegisterController;
use App\Http\Controllers\Api_v1\ExpenseController;
use App\Http\Controllers\Api_v1\TagController;
use App\Http\Controllers\Api_v1\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register',[RegisterController::class,'register']);
Route::post('login',[loginController::class,'login']);
Route::post('logout',[loginController::class,'logout'])->middleware('auth:sanctum');




Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/expenses', ExpenseController::class);
    Route::apiResource('/tags', TagController::class);
});
