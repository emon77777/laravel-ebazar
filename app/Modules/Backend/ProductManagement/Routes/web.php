<?php

use Modules\ProductManagement\Http\Controllers\PromotionalProductController;
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

Route::group(['prefix' => 'admin', 'as' => 'backend.'], function () {
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('product_list', 'ProductController@productList')->name('product.list');
        Route::get('promo_product_list', 'PromotionalProductController@promoProductList')->name('promo_product.list');
        Route::get('category_list', 'CategoryController@categoryList')->name('category.list');
        Route::get('brand_list', 'BrandController@brandList')->name('brand.list');
        Route::get('product/changeStatus', 'ProductController@changeStatus');
        Route::get('_products', 'PromotionalProductController@filteredProducts');
        Route::get('promo_product/changeStatus', 'PromotionalProductController@changeStatus');
        Route::get('category/changeStatus', 'CategoryController@changeStatus');
        Route::get('brand/changeStatus', 'BrandController@changeStatus');

        Route::resource('products', 'ProductController')->except(['show']);
        Route::resource('promotional_products', 'PromotionalProductController')->except('show');
        Route::resource('categories', 'CategoryController')->except(['show']);
        Route::resource('brands', 'BrandController')->except(['show']);

        // Route::group(['middleware' => ['check_permission']], function () {
        // });
    });
});
Route::group(['prefix' => 'seller', 'as' => 'seller.'], function () {
    Route::group(['middleware' => 'auth:seller'], function () {
        Route::get('product_list', 'ProductController@productList')->name('product.list');
        Route::get('promo_product_list', 'PromotionalProductController@promoProductList')->name('promo_product.list');
        Route::get('category_list', 'CategoryController@categoryList')->name('category.list');
        Route::get('brand_list', 'BrandController@brandList')->name('brand.list');
        Route::get('product/changeStatus', 'ProductController@changeStatus');
        Route::get('_products', 'PromotionalProductController@filteredProducts');
        Route::get('promo_product/changeStatus', 'PromotionalProductController@changeStatus');
        Route::get('category/changeStatus', 'CategoryController@changeStatus');
        Route::get('brand/changeStatus', 'BrandController@changeStatus');
        Route::group(['middleware' => ['check_permission']], function () {
            Route::resource('products', 'ProductController')->except(['show']);
            Route::resource('promotional_products', 'PromotionalProductController')->except('show');
            Route::resource('categories', 'CategoryController')->except(['show']);
            Route::resource('brands', 'BrandController')->except(['show']);
        });
    });
});
