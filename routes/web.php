<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect(route('home'))->withSuccess('Welcome to inventory system made with ❤ by William Galas');
});

Auth::routes(['register'=>false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/suppliers', 'SupplierControllers')->middleware('auth');
Route::resource('/products', 'ProductsController')->middleware('auth');
Route::resource('/carts', 'CartsController')->middleware(['isAdmin','auth']);
Route::resource('/checkout', 'CheckoutController')->middleware(['isAdmin','auth']);
Route::resource('/inventories','InventoriesController')->middleware(['isAdmin','auth']);
Route::resource('/receipts', 'ReceiptController')->middleware(['isAdmin','auth']);
Route::resource('/saves', 'IncomeController')->middleware(['isAdmin','auth']);
