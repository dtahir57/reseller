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

Route::post('user/register', 'UserController@register')->name('user.register');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('terms_and_condition', 'UserController@terms_and_condition')->name('terms_and_condition');

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', 'HomeController@logout')->name('user.logout');
    /**
     * Starting Routes For Super_User Role
     */
    Route::group(['middleware' => 'role:Super_User', 'prefix' => 'admin'], function () {
        Route::get('resellers', 'Admin\ResellerController@index')->name('admin.reseller.index');
        Route::get('reseller/create', 'Admin\ResellerController@create')->name('admin.reseller.create');
        Route::post('reseller', 'Admin\ResellerController@store')->name('admin.reseller.store');
        Route::get('reseller/{id}/edit', 'Admin\ResellerController@edit')->name('admin.reseller.edit');
        Route::get('reseller/discount', 'Admin\ResellerController@create_discount')->name('admin.reseller.create_discount');
        Route::post('reseller/discount', 'Admin\ResellerController@reseller_discount')->name('admin.reseller.discount');
        Route::patch('reseller/{id}', 'Admin\ResellerController@update')->name('admin.reseller.update');
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
        /**
         * Starting Routes For Admin\EarningController
         */
        Route::get('earnings', 'Admin\EarningController@index')->name('admin.earnings.index');
        Route::post('earning/screenshot/{id}', 'Admin\EarningController@store')->name('admin.earning.store');
        /**
         * Ending Routes For Admin\EarningController
         */
    });
    /**
     * Ending Routes For Super_User Role
     */
    Route::get('products', 'Product\ProductController@index')->name('product.index');

    Route::group(['middleware' => 'role:Reseller'], function () {
        /**
         * Starting Routes For Order\OrderController
         */
        Route::get('orders', 'Order\OrderController@index')->name('order.index');
        Route::get('order/create', 'Order\OrderController@create')->name('order.create');
        Route::post('order', 'Order\OrderController@store')->name('order.store');
        Route::post('search_products', 'Order\OrderController@search_products')->name('order.search_products');
        Route::post('get_product', 'Order\OrderController@get_product')->name('order.get_product');
        Route::get('order/destroy/{id}', 'Order\OrderController@destroy')->name('order.destroy');
        /**
         * Ending Routes For Order\OrderController
         */
        /**
         * Starting Routes For Discount\DiscountController
         */
        Route::get('discount/products', 'Discount\DiscountController@index')->name('reseller.discount.products');
        /**
         * Ending Routes For Discount\DiscountController
         */
        /**
         * Starting Routes For Earning\EarningController
         */
        Route::get('earnings', 'Earning\EarningController@index')->name('earning.index');
        /**
         * Ending Routes For Earning\EarningController
         */
    });
});
