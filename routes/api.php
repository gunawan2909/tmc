<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {


    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/show/{category}', [CategoryController::class, 'show'])->name('category.show');
    Route::post('category/add', [CategoryController::class, 'store'])->name('category.add');
    Route::post('category/update/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('category/delete/{category}', [CategoryController::class, 'destroy'])->name('category.delete');



    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::post('product/add', [ProductController::class, 'store'])->name('product.add');
    Route::get('product/show/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::post('product/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::post('product/delete/{product}', [ProductController::class, 'destroy'])->name('product.delete');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
});
