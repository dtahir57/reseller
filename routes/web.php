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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', 'HomeController@logout')->name('user.logout');
    Route::group(['middleware' => 'role:Super_User', 'prefix' => 'admin'], function () {
        Route::get('resellers', 'Admin\ResellerController@index')->name('admin.reseller.index');
        Route::get('reseller/create', 'Admin\ResellerController@create')->name('admin.reseller.create');
        Route::post('reseller', 'Admin\ResellerController@store')->name('admin.reseller.store');
        Route::get('reseller/destroy/{id}', 'Admin\ResellerController@destroy')->name('admin.reseller.destroy');
    });
    Route::get('products', 'Product\ProductController@index')->name('product.index');
});

Route::get('register', function() {
    return redirect()->route('login');
});
