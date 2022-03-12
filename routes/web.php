<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController as User;
use App\Http\Controllers\DashboardController as Dashboard;
use App\Http\Controllers\CategoryController as Category;
use App\Http\Controllers\ProductController as Product;
use App\Http\Controllers\StoreController as Store;
use App\Http\Controllers\RatingController as Rating;
use App\Http\Controllers\HistoryController as History;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// route for user (page and login process) 
Route::get('/', [User::class, 'index'])->name('user');
Route::post('/login', [User::class, 'login'])->name('user.login');
Route::post('/logout', [User::class, 'logout'])->name('user.logout');

// Route::middleware(['isAdmin'])->group(function(){
    
    // route dashboard
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

    // route category
    Route::resource('/category', Category::class);

    // route product
    Route::get('/product', [Product::class, 'index'])->name('product');
    
    // route store
    Route::get('/store', [Store::class, 'index'])->name('store');
    
    // route user
    Route::get('/user', [User::class, 'user'])->name('user.data');
    
    // route rating
    Route::get('/rating', [Rating::class, 'index'])->name('rating');
    
    // route history
    Route::get('/history', [History::class, 'index'])->name('history');

// });