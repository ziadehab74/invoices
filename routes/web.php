<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// *
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register web routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | contains the "web" middleware group. Now create something great!
// |
// */

Route::get('/', function () {
    return view('auth.login');
});
Route::resource('invoices', 'App\Http\Controllers\InvoicesController');
Route::resource('sections', 'App\Http\Controllers\SectionsController');
Route::resource('products', 'App\Http\Controllers\ProductsController');
Route::get('/section/{id}', 'InvoicesController@getproducts');
Route::resource('products/update', 'App\Http\Controllers\ProductsController@update');
Route::get('/edit_invoice/{id}', 'App\Http\Controllers\InvoicesController@edit');
Route::get('/section/{id}', [App\Http\Controllers\InvoicesController::class, 'getproducts'])->name('getproducts');


Auth::routes(['register'=>false]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

