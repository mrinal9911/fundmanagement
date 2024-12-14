<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundController;

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

Route::get('login', [FundController::class, 'login']);
Route::post('login', [FundController::class, 'userlogin']);
Route::get('/', [FundController::class, 'friendList']);
Route::get('add-fund', [FundController::class, 'addFund']);
Route::post('datasaved', [FundController::class, 'datasaved']);
Route::get('add-user', [FundController::class, 'addUser']);
Route::post('create-user', [FundController::class, 'createUser']);
Route::get('details/{id}', [FundController::class, 'fundDetailbyId']);
Route::get('ledger', [FundController::class, 'ledger']);
Route::get('loan', [FundController::class, 'loanHome']);
Route::get('loan/{id}', [FundController::class, 'loanDetails']);
Route::get('loan/provide/{id}', [FundController::class, 'provideLoan']);
Route::get('fd', [FundController::class, 'viewFixdeposit']);
Route::post('postfd', [FundController::class, 'storeFixdeposit'])->name('postfd');



Route::post('/provide-loan', [FundController::class, 'storeLoan'])->name('provideLoan');

// Show the Add Ledger form
Route::get('add-ledger', [FundController::class, 'createLedger']);

// Handle the form submission
Route::post('add-ledger', [FundController::class, 'storeLedger']);