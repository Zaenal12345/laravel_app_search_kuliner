<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\ProductController as ProductControllerAPI;
use App\Http\Controllers\API\UserController as UserControllerAPI;
use App\Http\Controllers\API\RatingController as RatingControllerAPI;
use App\Http\Controllers\API\HistoryController as HistoryControllerAPI;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/category', App\Http\Controllers\API\CategoryController::class);
Route::apiResource('/store', App\Http\Controllers\API\StoreController::class);

Route::get('/product', [ProductControllerAPI::class, 'index']);
Route::post('/product', [ProductControllerAPI::class, 'store']);
Route::put('/product/{product}', [ProductControllerAPI::class, 'update']);
Route::delete('/product/{product}', [ProductControllerAPI::class, 'destroy']);

Route::get('/rating', [RatingControllerAPI::class, 'index']);
Route::get('/show_rating', [RatingControllerAPI::class, 'showRating']);
Route::post('/rating', [RatingControllerAPI::class, 'store']);

Route::get('/history', [HistoryControllerAPI::class, 'index']);
Route::get('/show_history', [HistoryControllerAPI::class, 'showHistory']);
Route::post('/history', [HistoryControllerAPI::class, 'store']);

Route::get('/user', [UserControllerAPI::class, 'index']);
Route::post('/register_user', [UserControllerAPI::class, 'registerUser']);
Route::post('/register_store_owner', [UserControllerAPI::class, 'registerStoreOwner']);
Route::post('/register_admin', [UserControllerAPI::class, 'registerAdmin']);

