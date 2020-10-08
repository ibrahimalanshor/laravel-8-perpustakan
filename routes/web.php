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

Auth::routes([
	'verivy' => false,
	'reset' => false
]);

Route::middleware('auth')->group(function ()
{
	
	Route::get('/', 'HomeController@index')->name('home');

	Route::post('/book/get', 'BookController@get')->name('book.get');
	Route::post('/category/get', 'CategoryController@get')->name('category.get');
	Route::post('/member/get', 'MemberController@get')->name('member.get');

	Route::prefix('/stock')->name('stock.')->group(function ()
	{
		Route::get('/add', 'StockController@add')->name('add');
		Route::get('/remove', 'StockController@remove')->name('remove');

		Route::post('/create', 'StockController@create')->name('create');
		Route::delete('/destroy/{stock}', 'StockController@destroy')->name('destroy');
	});

	Route::prefix('/loan')->name('loan.')->group(function ()
	{
		Route::patch('/return/{loan}', 'LoanController@return')->name('return');
		Route::patch('/extend/{loan}', 'LoanController@extend')->name('extend');
	});

	Route::prefix('/setting')->name('setting.')->group(function ()
	{
		Route::view('/', 'setting.index')->name('index');
		Route::put('/save', 'SettingController@save')->name('save');
	});

	Route::prefix('/profile')->name('profile.')->group(function ()
	{
		Route::view('/', 'profile.index')->name('index');
		Route::put('/save', 'ProfileController@save')->name('save');
	});

	Route::resource('/book', 'BookController')->except(['show', 'edit']);
	Route::resource('/category', 'CategoryController')->except(['show', 'edit', 'create']);
	Route::resource('/loan', 'LoanController')->except(['show', 'edit', 'update']);
	Route::resource('/member', 'MemberController')->except(['edit']);

});