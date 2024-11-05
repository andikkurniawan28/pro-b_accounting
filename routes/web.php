<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CashFlowController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountGroupController;
use App\Http\Controllers\BalanceSheetController;
use App\Http\Controllers\IncomeStatementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', DashboardController::class)->name('dashboard')->middleware(['auth']);
Route::resource('/setting', SettingController::class)->middleware(['auth']);
Route::resource('/role', RoleController::class)->middleware(['auth', 'check.permission']);
Route::resource('/user', UserController::class)->middleware(['auth', 'check.permission']);
Route::resource('/currency', CurrencyController::class)->middleware(['auth', 'check.permission']);
Route::resource('/account_group', AccountGroupController::class)->middleware(['auth', 'check.permission']);
Route::resource('/account', AccountController::class)->middleware(['auth', 'check.permission']);
Route::resource('/journal', JournalController::class)->middleware(['auth', 'check.permission']);
Route::get('/ledger', [LedgerController::class, 'index'])->name('ledger.index')->middleware(['auth']);
Route::get('/ledger/data/{account_id}/{start_date}/{end_date}', [LedgerController::class, 'getData'])->name('ledger.data');
Route::get('/balance_sheet', [BalanceSheetController::class, 'index'])->name('balance_sheet.index')->middleware(['auth', 'check.permission']);
Route::get('/balance_sheet/data/{year}/{month}', [BalanceSheetController::class, 'data'])->name('balance_sheet.data');
Route::get('/income_statement', [IncomeStatementController::class, 'index'])->name('income_statement.index')->middleware(['auth', 'check.permission']);
Route::get('/income_statement/data/{year}/{month}', [IncomeStatementController::class, 'data'])->name('income_statement.data');
Route::get('/cash_flow', [CashFlowController::class, 'index'])->name('cash_flow.index')->middleware(['auth', 'check.permission']);
Route::get('/cash_flow/data/{year}/{month}', [CashFlowController::class, 'data'])->name('cash_flow.data');
