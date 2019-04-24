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


Auth::routes();

Route::get('/', 'WelcomeController')->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');

/* users */

Route::get('/users', 'UserController@index')->name('users');

Route::post('/users/create', 'UserController@store')->name('create-user');

Route::patch('/users/update', 'UserController@update')->name('update-user');

Route::delete('/users/delete/{user}', 'UserController@destroy')->where('user', '\d+')->name('delete-user');

/* users */

/* branch-offices */

Route::get('/branch-offices', 'BranchOfficesController@index')->name('branch-offices');

Route::post('/branch-offices/create', 'BranchOfficesController@store')->name('create-branch-office');

Route::patch('/branch-offices/update', 'BranchOfficesController@update')->name('update-branch-office');

Route::delete('/branch-offices/delete/{branchOffice}', 'BranchOfficesController@destroy')->where('branchOffice', '\d+')->name('delete-branch-office');

/* branch-offices */

/* movement */

Route::get('/movements', 'MovementController@index')->name('movements');

Route::post('/movements/create', 'MovementController@store')->name('create-movement');

Route::patch('/movements/update', 'MovementController@update')->name('update-movement');

Route::delete('/movements/delete/{movement}', 'MovementController@destroy')->where('movement', '\d+')->name('delete-movement');

/* movement */

/* Boxes */

Route::get('/boxes', 'BoxController@index')->name('boxes');

Route::post('/boxes/create', 'BoxController@store')->name('create-box');

Route::patch('/boxes/update', 'BoxController@update')->name('update-box');

Route::get('/boxes/{box}/product', 'BoxController@show')->where('box', '\d+')->name('products-for-box');

Route::post('/boxes/add/product', 'BoxController@create')->name('add-product');

Route::delete('/boxes/delete/products/{product}', 'BoxController@destroy')->where('product', '\d+')->name('delete-product-for-box');

/* Boxes */

/* products */

Route::get('/products', 'ProductController@index')->name('products');

Route::post('/products/create', 'ProductController@store')->name('create-product');

Route::patch('/products/update', 'ProductController@update')->name('update-product');

Route::delete('/product/delete/{product}', 'ProductController@destroy')->where('product', '\d+')->name('delete-product');

/* products */

/* inventories */

Route::get('/inventories', 'InventoryController@index')->name('inventories');

Route::post('/inventories/create', 'InventoryController@store')->name('create-inventory');

Route::patch('/inventories/update', 'InventoryController@update')->name('update-inventory');

Route::delete('/inventories/delete/{inventory}', 'InventoryController@destroy')->where('inventory', '\d+')->name('delete-inventory');

/* inventories */
