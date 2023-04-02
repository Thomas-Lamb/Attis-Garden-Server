<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BacController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompartimentController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\TicketController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/register', [UserController::class, 'register']);
Route::get('user/login', [UserController::class, 'login']);

route::middleware('auth.api')->group(function () {
    Route::put('user/pwd', [UserController::class, 'changeMdp']);
});

route::middleware('auth.api')->group(function () {
    Route::delete('user/{user}', [UserController::class, 'destroy']);
});

route::middleware('auth.api')->group(function () {
    Route::put('user', [UserController::class, 'update']);
});

route::middleware('auth.api')->group(function () {
    Route::get('user', [UserController::class, 'index']);
});

route::middleware('auth.api')->group(function () {
    Route::apiResource('bac', BacController::class);
});

route::middleware('auth.api')->group(function () {
    Route::apiResource('compartiment', CompartimentController::class);
});

route::middleware('auth.api')->group(function () {
    Route::apiResource('produit', ProduitController::class);
});

route::middleware('auth.api')->group(function () {
    Route::apiResource('stock', StockController::class);
});

route::middleware('auth.api')->group(function () {
    Route::apiResource('ai', AIController::class);
});

route::middleware('auth.api')->group(function () {
    Route::apiResource('commande', CommandeController::class);
});

Route::get('ticket', [TicketController::class, 'index']);
Route::post('ticket', [TicketController::class, 'store']);