<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SmokeController;
use App\Http\Controllers\BuyerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::middleware('admin')->group(function () {
        Route::resource('/users', UserController::class);
    });
    
    Route::middleware('owner')->group(function () {
        Route::resource('/customers', CustomerController::class);
        Route::get('/customers/list/{type}', [CustomerController::class, 'pending']);
        Route::get('/customers/list/{type}/lunas', [CustomerController::class, 'lunas']);
        Route::get('/customers/log/{customer:id}', [CustomerController::class, 'createLog']);
        Route::post('/customers/log', [CustomerController::class, 'storeLog']);
    
        Route::resource('/logs', LogController::class);
        Route::resource('/smokes', SmokeController::class);
        Route::resource('/buyers', BuyerController::class);
        Route::get('/buyers/list/{type}', [BuyerController::class, 'pending']);
        Route::get('/buyers/list/{type}/lunas', [BuyerController::class, 'lunas']);
        Route::put('/buyers/confirm/{buyer:id}', [BuyerController::class, 'confirm']);
        Route::get('/reports', [BuyerController::class, 'reports']);

    });
});

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});
