<?php

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


use PhpParser\Node\Expr\Include_;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('categories', 'CategoryController');
Route::get('income_moneys/month', 'Income_moneyController@month')->name('income_moneys.month');

Route::resource('income_moneys', 'Income_moneyController');
//Route::get('pay_moneys/month', 'Pay_moneyController@month')->name('pay_moneys.month');


Route::resource('pay_moneys', 'Pay_moneyController');
