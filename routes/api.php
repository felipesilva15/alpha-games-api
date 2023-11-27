<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchCepController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('/login', [AuthController::class, 'login']);

// User
Route::post('/user', [UserController::class, 'store']);

// Products
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

// Search CEP
Route::get('/cep/{cep}', [SearchCepController::class, 'getAddressByCep']);
Route::post('/refresh-token', [AuthController::class, 'refresh']);

Route::group(['middleware' => 'auth:api'], function () {
    // User
    Route::get('/user/adresses', [UserController::class, 'adresses']);
    Route::get('/user/cart', [UserController::class, 'cart']);
    Route::get('/user/orders', [UserController::class, 'orders']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/me', [AuthController::class, 'me']);

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // Adresses
    Route::apiResource('address', AddressController::class);

    // Cart
    Route::patch('/cart/{product}', [CartController::class, 'store']);
    Route::delete('/cart/{product}', [CartController::class, 'destroy']);

    // Order
    Route::get('/order/{order}', [OrderController::class, 'show']);
    Route::post('/order', [OrderController::class, 'store']);
});