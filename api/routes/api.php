<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BooksController;
use App\Http\Controllers\API\BorrowController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);


Route::middleware('auth:api')->group(function () {
    Route::get('books', [BooksController::class, 'index']);
    Route::get('user', [AuthController::class, 'getuser']);
    Route::prefix('borrow')->group(function () {
        Route::get('/', [BorrowController::class, 'index']);
        Route::post('/', [BorrowController::class, 'create']);
        Route::put('/{id}', [BorrowController::class, 'update']);
        Route::delete('/{id}', [BorrowController::class, 'destroy']);
    });
});


