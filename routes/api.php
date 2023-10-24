<?php

use App\Http\Clients\ViacepClient;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Login
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh-token', [AuthController::class, 'refresh']);
Route::get('me', [AuthController::class, 'me']);
Route::post('logout', [AuthController::class, 'logout']);

// User
Route::post('user', [UserController::class, 'store']);

// Products
Route::get("product", [ProductController::class, 'index']);
Route::get("product/{id}", [ProductController::class, 'show']);

Route::get("cep/{cep}", function() {
    $client = new ViacepClient();
    $address = $client->getAddressByCep(request('cep'));

    return response()->json($address->toArray(), 200);
});

Route::group(['middleware' => 'auth:api'], function () {
    // User
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::get('/user', [UserController::class, 'index']);
});