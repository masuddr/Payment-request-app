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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', 'UsersController@showpayments');


//Route::get('/molliepayment', function () {
//    return view('molliepayment');
//});



Route::resource('transactions','TransactionsController')->middleware('auth');
Route::resource('payments','PaymentsController')->middleware('auth');

Route::get('/confirmed','PaymentsController@confirmedPayment');

Route::get('/view','TransactionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);
