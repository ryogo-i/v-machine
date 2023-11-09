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

Auth::routes();
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ユーザー新規登録画面
Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/store', 'App\Http\Controllers\ProductController@store')->name('products.store');

// 商品一覧画面
Route::middleware(['auth'])->group(function () {
    Route::get('/list', 'App\Http\Controllers\ProductController@index')->name('products.list');
});
// 検索ボタン押下時
Route::get('/search', 'App\Http\Controllers\ProductController@search')->name('products.search');
// 削除ボタン押下時
Route::delete('/products/{product}', 'App\Http\Controllers\ProductController@destroy')->name('products.destroy');


// 詳細画面
Route::get('/detail/{product}', 'App\Http\Controllers\ProductController@show')->name('products.detail');


// 編集画面
Route::get('/edit/{product}', 'App\Http\Controllers\ProductController@edit')->name('products.edit');
Route::post('/edit/{product}', 'App\Http\Controllers\ProductController@update')->name('products.update');

// 商品新規登録画面
Route::get('/create', 'App\Http\Controllers\ProductController@create')->name('products.create');
Route::post('/store', 'App\Http\Controllers\ProductController@store')->name('products.store');

