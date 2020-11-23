

<?php

use Illuminate\Support\Facades\Route;
    Route::group(['prefix'  =>  'admin'], function () 
    {
        /**********LOG IN ADMIN PANEL********/
        Route::get('login', 'App\Http\Controllers\Admin\LoginController@showLoginForm')->name('admin.login');
        Route::post('login', 'App\Http\Controllers\Admin\LoginController@login')->name('admin.login.post');
        Route::get('logout', 'App\Http\Controllers\Admin\LoginController@logout')->name('admin.logout');

         /**********ADMIN DASHBOARD PANEL********/
        Route::group(['middleware' => ['auth:admin']], function () 
        {

            Route::get('/', function () 
            {
                return view('admin.dashboard.index');
            })->name('admin.dashboard');

            /**********SETTINGS ********/   
            Route::get('/settings', 'App\Http\Controllers\Admin\SettingController@index')->name('admin.settings');
            Route::post('/settings', 'App\Http\Controllers\Admin\SettingController@update')->name('admin.settings.update');

            /**********CATEGORIES ********/ 
            Route::group(['prefix'  =>   'categories'], function() 
            {

                Route::get('/', 'App\Http\Controllers\Admin\CategoryController@index')->name('admin.categories.index');
                Route::get('/create', 'App\Http\Controllers\Admin\CategoryController@create')->name('admin.categories.create');
                Route::post('/store', 'App\Http\Controllers\Admin\CategoryController@store')->name('admin.categories.store');
                Route::get('/{id}/edit', 'App\Http\Controllers\Admin\CategoryController@edit')->name('admin.categories.edit');
                Route::post('/update', 'App\Http\Controllers\Admin\CategoryController@update')->name('admin.categories.update');
                Route::get('/{id}/delete', 'App\Http\Controllers\Admin\CategoryController@delete')->name('admin.categories.delete');
            
            });
            /******ATTRIBUTES************/
            Route::group(['prefix'  =>   'attributes'], function() 
            {

                Route::get('/', 'App\Http\Controllers\Admin\AttributeController@index')->name('admin.attributes.index');
                Route::get('/create', 'App\Http\Controllers\Admin\AttributeController@create')->name('admin.attributes.create');
                Route::post('/store', 'App\Http\Controllers\Admin\AttributeController@store')->name('admin.attributes.store');
                Route::get('/{id}/edit', 'App\Http\Controllers\Admin\AttributeController@edit')->name('admin.attributes.edit');
                Route::post('/update', 'App\Http\Controllers\Admin\AttributeController@update')->name('admin.attributes.update');
                Route::get('/{id}/delete', 'App\Http\Controllers\Admin\AttributeController@delete')->name('admin.attributes.delete');
                /*********ATTRIBUTE VALUES***********/
                Route::post('/get-values', 'App\Http\Controllers\Admin\AttributeValueController@getValues');
                Route::post('/add-values', 'App\Http\Controllers\Admin\AttributeValueController@addValues');
                Route::post('/update-values', 'App\Http\Controllers\Admin\AttributeValueController@updateValues');
                Route::post('/delete-values', 'App\Http\Controllers\Admin\AttributeValueController@deleteValues');

            });
            /**********BRANDS**********/
            Route::group(['prefix'  =>   'brands'], function() {

                Route::get('/', 'App\Http\Controllers\Admin\BrandController@index')->name('admin.brands.index');
                Route::get('/create', 'App\Http\Controllers\Admin\BrandController@create')->name('admin.brands.create');
                Route::post('/store', 'App\Http\Controllers\Admin\BrandController@store')->name('admin.brands.store');
                Route::get('/{id}/edit', 'App\Http\Controllers\Admin\BrandController@edit')->name('admin.brands.edit');
                Route::post('/update', 'App\Http\Controllers\Admin\BrandController@update')->name('admin.brands.update');
                Route::get('/{id}/delete', 'App\Http\Controllers\Admin\BrandController@delete')->name('admin.brands.delete');
            
            });
            /**********PRODUCTS**********/
            Route::group(['prefix' => 'products'], function () {

                Route::get('/', 'App\Http\Controllers\Admin\ProductController@index')->name('admin.products.index');
                Route::get('/create', 'App\Http\Controllers\Admin\ProductController@create')->name('admin.products.create');
                Route::post('/store', 'App\Http\Controllers\Admin\ProductController@store')->name('admin.products.store');
                Route::get('/edit/{id}', 'App\Http\Controllers\Admin\ProductController@edit')->name('admin.products.edit');
                Route::post('/update', 'App\Http\Controllers\Admin\ProductController@update')->name('admin.products.update');
                /* IMAGES */
                Route::post('images/upload', 'App\Http\Controllers\Admin\ProductImageController@upload')->name('admin.products.images.upload');
                Route::get('images/{id}/delete', 'App\Http\Controllers\Admin\ProductImageController@delete')->name('admin.products.images.delete');
                /* ATTRIBUTES */
                    // Load attributes on the page load
                    Route::get('attributes/load', 'App\Http\Controllers\Admin\ProductAttributeController@loadAttributes');
                    // Load product attributes on the page load
                    Route::post('attributes', 'App\Http\Controllers\Admin\ProductAttributeController@productAttributes');
                    // Load option values for a attribute
                    Route::post('attributes/values', 'App\Http\Controllers\Admin\ProductAttributeController@loadValues');
                    // Add product attribute to the current product
                    Route::post('attributes/add', 'App\Http\Controllers\Admin\ProductAttributeController@addAttribute');
                    // Delete product attribute from the current product
                    Route::post('attributes/delete', 'App\Http\Controllers\Admin\ProductAttributeController@deleteAttribute');
             });
             /***********ORDER MANAGEMENT*********/
             Route::group(['prefix' => 'orders'], function () {
                Route::get('/', 'App\Http\Controllers\Admin\OrderController@index')->name('admin.orders.index');
                Route::get('/{order}/show', 'App\Http\Controllers\Admin\OrderController@show')->name('admin.orders.show');
             });
        });
    });
?>
