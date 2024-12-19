<?php

use App\Http\Controllers\Api\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PodcastController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', UserController::class);
Route::post('/login', [UserController::class, 'login']);
Route::get('/podcasts', [PodcastController::class, 'index']);
Route::middleware('auth:sanctum')->post('/podcasts', [PodcastController::class, 'store']);
Route::middleware('auth:sanctum')->post('/balance', [WalletController::class, 'balance'])->name('user.balance');
Route::middleware('auth:sanctum')->post('/actual_balance', [WalletController::class, 'actual_balance'])->name('user.actual_balance')->middleware('auth:api');
Route::middleware('auth:sanctum')->post('/deduct-coin', [WalletController::class, 'deduct_coin'])->name('deduct.coin');
Route::middleware('auth:sanctum')->post('/recharge-coin', [WalletController::class, 'recharge_coin']);
