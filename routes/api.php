<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DebitController;

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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('/users', UserController::class)->only(['index', 'show', 'update', 'destroy']);

    Route::apiResource('/categories', CategoryController::class);

    Route::apiResource('categories.debits', DebitController::class);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});


