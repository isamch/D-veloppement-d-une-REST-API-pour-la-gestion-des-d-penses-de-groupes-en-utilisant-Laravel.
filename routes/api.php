<?php

use App\Http\Controllers\Api_v1\Auth\LoginController;
use App\Http\Controllers\Api_v1\Auth\RegisterController;
use App\Http\Controllers\Api_v1\ExpenseController;
use App\Http\Controllers\Api_v1\TagController;
use App\Http\Controllers\Api_v1\UserController;
use App\Http\Controllers\Api_v1\GroupController;
use App\Http\Controllers\Api_v1\BalanceController;
use App\Http\Controllers\Api_v1\SettlementController;
use App\Http\Controllers\Api_v1\BudgetController;
use App\Http\Controllers\Api_v1\AlertController;
use App\Http\Controllers\Api_v1\RecurringExpenseController;
use App\Http\Controllers\Api_v1\ReportController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth Routes
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

// Authenticated Routes Group
Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [LoginController::class, 'logout']);

    // User Routes
    Route::apiResource('users', UserController::class);

    // Expense Routes
    Route::apiResource('expenses', ExpenseController::class);

    // Tag Routes
    Route::apiResource('tags', TagController::class);

    // Group Routes
    Route::prefix('groups')->group(function () {
        Route::post('/', [GroupController::class, 'store']);
        Route::get('/', [GroupController::class, 'index']);
        Route::get('{group}', [GroupController::class, 'show']);
        Route::delete('{group}', [GroupController::class, 'destroy']);

        // Expense Routes under Group
        Route::post('{group}/expenses', [ExpenseController::class, 'store']);
        Route::get('{group}/expenses', [ExpenseController::class, 'index']);
        Route::delete('{group}/expenses/{expense}', [ExpenseController::class, 'destroy']);

        // Balance Routes under Group
        Route::get('{group}/balances', [BalanceController::class, 'index']);

        // Settlement Routes under Group
        Route::post('{group}/settle', [SettlementController::class, 'store']);
        Route::get('{group}/history', [SettlementController::class, 'index']);
    });

    // Budget Routes
    Route::prefix('budgets')->group(function () {
        Route::post('/', [BudgetController::class, 'store']);
        Route::get('/', [BudgetController::class, 'index']);
        Route::put('{budget}', [BudgetController::class, 'update']);
        Route::delete('{budget}', [BudgetController::class, 'destroy']);
    });

    // Alert Routes
    Route::get('alerts', [AlertController::class, 'index']);

    // Recurring Expense Routes
    Route::prefix('recurring-expenses')->group(function () {
        Route::post('/', [RecurringExpenseController::class, 'store']);
        Route::get('/', [RecurringExpenseController::class, 'index']);
        Route::delete('{recurringExpense}', [RecurringExpenseController::class, 'destroy']);
    });

    // Report Routes
    Route::prefix('reports')->group(function () {
        Route::get('summary', [ReportController::class, 'summary']);
        Route::get('custom', [ReportController::class, 'custom']);
    });
});
