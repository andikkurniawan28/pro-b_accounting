<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AccountGroupController;
use App\Http\Controllers\BalanceSheetController;

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

Route::get('/', function () {
    return view('welcome');
})->name('dashboard')->middleware(['auth']);

// Auth
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('/setting', SettingController::class)->middleware(['auth']);
Route::resource('/role', RoleController::class)->middleware(['auth']);
Route::resource('/user', UserController::class)->middleware(['auth']);
Route::resource('/account_group', AccountGroupController::class)->middleware(['auth']);
Route::resource('/account', AccountController::class)->middleware(['auth']);
Route::resource('/journal', JournalController::class)->middleware(['auth']);
Route::get('/ledger', [LedgerController::class, 'index'])->name('ledger.index')->middleware(['auth']);
Route::get('/ledger/data/{account_id}/{start_date}/{end_date}', [LedgerController::class, 'getData'])->name('ledger.data');
Route::get('/balance_sheet', [BalanceSheetController::class, 'index'])->name('balance_sheet.index')->middleware(['auth']);
Route::get('/balance_sheet/data/{year}/{month}', [BalanceSheetController::class, 'data'])->name('balance_sheet.data');
