<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MakePaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// auth
Route::prefix('auth/')->name("auth.")->group(function() {
    Route::group(['middleware' => ['guest']], function() {
        Route::get('/login', [UserController::class, 'login'])->name('login');
        Route::post('/login', [UserController::class, 'post_login'])->name('post_login');

        Route::get('/register', [UserController::class, 'register'])->name('register');
        Route::post('/register', [UserController::class, 'post_register'])->name('post_register');
    });

    Route::group(['middleware' => ['auth']], function() {
        Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    });
});

// dashboard
Route::group(['middleware' => ['auth']], function() {
    Route::prefix('dashboard/')->name("dashboard.")->group(function() {

        // admin
        Route::group(['middleware' => ['role:admin']], function () {
            // customer
            Route::prefix('customer/')->name("customer.")->group(function() {
                // data
                Route::prefix('data/')->name("data.")->group(function() {
                    Route::get('/', [CustomerController::class, 'index'])->name('index');
                    Route::get('/create', [CustomerController::class, 'create'])->name('create');
                    Route::post('/create', [CustomerController::class, 'store'])->name('store');
                    Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('edit');
                    Route::put('/edit/{id}', [CustomerController::class, 'update'])->name('update');
                    Route::delete('/delete/{id}', [CustomerController::class, 'delete'])->name('delete');
                });
            });

            // Product
            Route::prefix('product/')->name("product.")->group(function() {
                // data
                Route::prefix('data/')->name("data.")->group(function() {
                    Route::get('/', [ProductController::class, 'index'])->name('index');
                    Route::get('/create', [ProductController::class, 'create'])->name('create');
                    Route::post('/create', [ProductController::class, 'store'])->name('store');
                    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
                    Route::put('/edit/{id}', [ProductController::class, 'update'])->name('update');
                    Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
                });
            });

            // history
            Route::prefix('transaction/')->name("transaction.")->group(function() {
                Route::get('/', [HistoryController::class, 'index_admin'])->name('index');
            });
        });

        // user
        Route::group(['middleware' => ['role:user']], function () {
            // Transaction
            Route::prefix('transaction/')->name("transaction.")->group(function() {
                // make
                Route::prefix('make/')->name("make.")->group(function() {
                    Route::get('/', [MakePaymentController::class, 'index'])->name('index');
                    Route::post('/', [MakePaymentController::class, 'store'])->name('store');
                });

                // history
                Route::prefix('history/')->name("history.")->group(function() {
                    Route::get('/', [HistoryController::class, 'index'])->name('index');
                    Route::post('/{code}', [HistoryController::class, 'update'])->name('update');
                });
            });
        });
    });
});
