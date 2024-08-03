<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'SignInView'])->name('login');
    Route::post('/login', [AuthController::class, 'SignInPost'])->name('login.post');
});

/* For Main */
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'SignOut'])->name('logout.post');

    /* Product */
    Route::get('/product', [ProductController::class, 'ProductView'])->name('product');
    Route::get('/product/add', [ProductController::class, 'ProductAddView'])->name('addproduct');
    Route::Post('/product/add', [ProductController::class, 'ProductAddPost'])->name('addproduct.post');
    Route::get('/product/update/{id}', [ProductController::class, 'ProductUpdateView'])->name('updateproduct');
    Route::put('/product/update/{id}', [ProductController::class, 'ProductUpdatePut'])->name('updateproduct.put');
    Route::delete('/product/delete/{id}', [ProductController::class, 'ProductDelete'])->name('deleteproduct.destroy');

    /* Category */
    Route::get('/category', [CategoryController::class, 'CategoryView'])->name('category');
    Route::get('/category/add', [CategoryController::class, 'CategoryAddView'])->name('addcategory');
    Route::Post('/category/add', [CategoryController::class, 'CategoryAddPost'])->name('addcategory.post');
    Route::get('/category/update/{id}', [CategoryController::class, 'CategoryUpdateView'])->name('updatecategory');
    Route::put('/category/update/{id}', [CategoryController::class, 'CategoryUpdatePut'])->name('updatecategory.put');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'CategoryDelete'])->name('deletecategory.destroy');

    /* Transaction */
    Route::get('/transaction', [TransactionController::class, 'TransactionView'])->name('transaction');
    Route::post('/transaction', [TransactionController::class, 'TransactionPost'])->name('transaction.post');
    Route::get('/transactionhistory', [TransactionController::class, 'HistoryTransactionView'])->name('historytransaction');
    Route::get('/transactionhistory/detail/{id}', [TransactionController::class, 'HistoryTransactionDetailView'])->name('historytransactiondetail');
});
