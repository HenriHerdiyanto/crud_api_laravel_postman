<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resource('users', 'App\Http\Controllers\Api\UsersController');
Route::resource('products', 'App\Http\Controllers\Api\ProductController');
Route::put('/products/update/{id}', [App\Http\Controllers\Api\ProductController::class, 'update']);
Route::resource('categories', 'App\Http\Controllers\Api\CategoriesController');
Route::resource('orders', 'App\Http\Controllers\Api\OrdersController');
Route::resource('ordersDetail', 'App\Http\Controllers\Api\OrdersDetailController');

// Route::get('/posts', [App\Http\Controllers\Api\PostsController::class, 'index']);
