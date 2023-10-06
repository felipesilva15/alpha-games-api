<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Login
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh-token', [AuthController::class, 'refresh']);
Route::get('me', [AuthController::class, 'me']);
Route::post('logout', [AuthController::class, 'logout']);

// User
Route::post('user', [UserController::class, 'store']);

Route::group(['middleware' => 'auth:api'], function () {
    // User
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::get('/user', [UserController::class, 'index']);
});