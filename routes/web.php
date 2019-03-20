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


Route::get('/payment', function () {
    return view('payment');
});

Route::get('/pay', function () {
    return view('pay');
});

Route::get('/home', 'UsersController@showpayments');


//Route::get('/molliepayment', function () {
//    return view('molliepayment');
//});

Route::get('/molliepayment', 'PaymentsController@preparePayment');

Route::post('/submit', 'PaymentsController@pay');

Route::get('/payments', function () {
    return view('payments');
});





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
