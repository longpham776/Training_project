<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
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
    Route::post('/adduser','UsersController@addUser')->name('addUser');
    Route::get('/getUser','UsersController@getUser')->name('getUser');
    Route::post('/editUser','UsersController@editUser')->name('editUser');
});
#Customers
Route::group(['namespace'=>'App\Http\Controllers'],function(){
    
    Route::resource('customers', CustomerController::class)->except([
        'create','edit'
    ]);
});
#Products
Route::group(['namespace'=>'App\Http\Controllers'],function(){
    
});


