<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContentController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('test', [ContentController::class, 'test']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [ContentController::class, 'user']);
    Route::get('category', [ContentController::class, 'getAllCategories']);
    Route::get('kategori/pesanan', [ContentController::class, 'getAllCategoriesPesanan']);
    Route::get('products-by-category', [ContentController::class, 'getProductsByCategory']);
    Route::get('products-detail/{id}', [ContentController::class, 'getProductDetail']);
    Route::prefix('orders')->group(function () {
        Route::get('/', [ContentController::class, 'getShowMyOrder']);
        Route::get('/{id}', [ContentController::class, 'getShowDetailMyOrder']); // Detail order
        Route::post('/', [ContentController::class, 'order']);
        Route::post('/terima', [ContentController::class, 'terima']);
    });
    Route::get('order-history', [ContentController::class, 'getOrderHistory']);

});