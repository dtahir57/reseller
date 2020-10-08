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
    /**
     * Starting Routes For Super_User Role
     */
    Route::group(['middleware' => 'role:Super_User', 'prefix' => 'admin'], function () {
        Route::get('resellers', 'Admin\ResellerController@index')->name('admin.reseller.index');
        Route::get('reseller/create', 'Admin\ResellerController@create')->name('admin.reseller.create');
        Route::post('reseller', 'Admin\ResellerController@store')->name('admin.reseller.store');
        Route::get('reseller/destroy/{id}', 'Admin\ResellerController@destroy')->name('admin.reseller.destroy');
        /**
         * Starting Routes For DiscountController
         */
        Route::get('discounts', 'Admin\DiscountController@index')->name('admin.discount.index');
        Route::get('discount/create', 'Admin\DiscountController@create')->name('admin.discount.create');
        Route::post('discount', 'Admin\DiscountController@store')->name('admin.discount.store');
        Route::get('discount/{id}/edit', 'Admin\DiscountController@edit')->name('admin.discount.edit');
        Route::patch('discount/{id}', 'Admin\DiscountController@update')->name('admin.discount.update');
        Route::get('discount/destroy/{id}', 'Admin\DiscountController@destroy')->name('admin.discount.destroy');
        Route::post('search_product', 'Admin\DiscountController@search_product')->name('admin.search_product');
        Route::post('search_reseller', 'Admin\DiscountController@search_reseller')->name('admin.search_reseller');
        Route::post('get_product', 'Admin\DiscountController@get_product')->name('admin.get_product');
        Route::post('get_reseller', 'Admin\DiscountController@get_reseller')->name('admin.get_reseller');
        /**
         * Ending Routes For DiscountController
         */
    });
    /**
     * Ending Routes For Super_User Role
     */
    Route::get('products', 'Product\ProductController@index')->name('product.index');
    /**
     * Starting Routes For Order\OrderController
     */
    Route::group(['middleware' => 'role:Reseller'], function () {
        Route::get('orders', 'Order\OrderController@index')->name('order.index');
    });
    /**
     * Ending Routes For Order\OrderController
     */
});

Route::get('register', function() {
    return redirect()->route('login');
});
