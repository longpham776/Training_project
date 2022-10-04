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
#Users
Route::group(['namespace'=>'App\Http\Controllers'],function(){
    Route::get('/','UsersController@index')->name('home');
    Route::get('/login','UsersController@login')->name('login');
    Route::post('/postLogin','UsersController@postLogin')->name('postLogin');
    Route::get('/logout','UsersController@logout')->name('logout');
    Route::get('/delete/{id}','UsersController@delete')->name('delete');
    Route::get('/deact/{id}','UsersController@deact')->name('deact');
});
#Customers
Route::group(['namespace'=>'App\Http\Controllers'],function(){
    
});
#Products
Route::group(['namespace'=>'App\Http\Controllers'],function(){
    
});
