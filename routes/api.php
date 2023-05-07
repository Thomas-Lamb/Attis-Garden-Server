<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BacController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompartimentController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WikiController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PanierController;

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

// User Login/Register
Route::post('user/register', [UserController::class, 'register']);
Route::get('user/login', [UserController::class, 'login']);

// Reset password with email
Route::post('user/pwdreset', [UserController::class, 'pwdreset']);

Route::middleware('auth.api')->group(function () {
    // Update Password
    Route::put('user/pwd', [UserController::class, 'updatePwd']);

    // Update Email
    Route::put('user/email', [UserController::class, 'updateEmail']);

    // Delete User
    Route::delete('user', [UserController::class, 'destroy']);

    // Get info with api_token
    Route::get('user', [UserController::class, 'index']);

    // Api Bac
    Route::apiResource('bac', BacController::class);

    // Api compartiment
    Route::apiResource('compartiment', CompartimentController::class);

    // Api Produit
    Route::apiResource('produit', ProduitController::class);
    Route::get('produitgratuit', [ProduitController::class, 'gratuit']);

    // Api Stock
    //Route::apiResource('stock', StockController::class);

    // Api AI
    Route::apiResource('ai', AIController::class);

    // Api Commande
    Route::apiResource('commande', CommandeController::class);

    // Api Panier
    Route::apiResource('panier', PanierController::class);

    // Api Wiki
    Route::apiResource('wiki', WikiController::class);

});

// Administration
Route::middleware('privilege.modo')->group(function () {
    // Get all users
    Route::get('admin/user', [AdminController::class, 'index']);

    // Update user
    Route::put('admin/user', [AdminController::class, 'update']);

    // Delete user
    Route::delete('admin/user', [AdminController::class, 'destroy']);
});
// Api Tickets
Route::get('ticket', [TicketController::class, 'index']);
Route::post('ticket', [TicketController::class, 'store']);