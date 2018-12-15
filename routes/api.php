<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/login/', 'API\AuthController@login');
Route::post('auth/register', 'API\RegistrationController@register');
Route::get('email/verify/{token}', 'Auth\VerificationController@verifyEmail')->name('email.verify');

Route::group(['middleware' =>  'public-api'], function () {
    Route::get('/products/search', 'API\ProductController@searchProduct');
    Route::get('carousels', 'API\CarouselController@getCarousels');
});

Route::group(['middleware' => ['jwt.auth']], function(){
    Route::post('auth/logout', 'API\AuthController@logout');

    Route::group(['middleware' => 'admin-guard', 'prefix' => 'admin'], function () {
        Route::get('orders/status/{status}', 'API\TransactionController@getOrders');
        Route::get('banners', 'API\BannerController@getBanners');
        Route::post('banners/create', 'API\BannerController@storeBanner');
        Route::post('banners/{id}/update', 'API\BannerController@updateBanner');
        Route::post('banners/{id}/delete', 'API\BannerController@deleteBanner');
        Route::post('carousels/create', 'API\CarouselController@storeCarousel');
        Route::post('carousels/{id}/update', 'API\CarouselController@updateCarousel');
        Route::post('carousels/{id}/delete', 'API\CarouselController@deleteCarousel');
    });

    Route::group(['middleware' => 'merchant-guard', 'prefix' => 'merchant'], function () {
        Route::get('products', 'API\ProductController@getProductsByMerchant');
        Route::post('products/create', 'API\ProductController@storeProduct');
        Route::post('products/{id}/update', 'API\ProductController@updateProduct');
        Route::post('products/{id}/delete', 'API\ProductController@deleteProduct');
    });

    Route::group(['middleware' => 'customer-guard', 'prefix' => 'customer'], function () {
        Route::get('carts', 'API\CartController@getProductInCartByCustomer');
        Route::post('carts/create', 'API\CartController@insertProductToCart');
        Route::post('orders', 'API\OrderController@getCustomerOrder');
        Route::post('orders/create', 'API\OrderController@createCustomerOrder');
    });

    Route::get('products/{id}', 'API\ProductController@getProduct');
    Route::get('user', 'API\UserController@user');
});

Route::group(['middleware' => 'jwt.refresh'], function(){
    Route::get('auth/refresh', 'API\AuthController@refresh');
});

//Route::resource('/transactions', 'API\TransactionController');
//Route::resource('carts', 'API\CartController');
//Route::get('/carts/user/{id}', 'API\CartController@getUserCart');
//Route::get('/provinces', 'API\RegionalController@getProvinces');
//Route::get('/cities', 'API\RegionalController@getCities');
//Route::get('/subdistricts', 'API\RegionalController@getSubdistricts');
//Route::post('/shippingcost', 'API\RajaOngkirController@getShippingCost');
//Route::get('/merchant/{id}/new-orders', 'API\OrderController@getNewOrdersByMerchant');
//Route::get('/merchant/{id}/onprocess-orders', 'API\OrderController@getOnProcessOrdersByMerchant');
//Route::post('/orders/{id}/update-shipping-number', 'API\OrderController@updateShippingNumber');
//Route::post('/merchant/orders/{id}', 'API\OrderController@updateOrderStatus');
//Route::get('/customer/{id}/transactions', 'API\TransactionController@getCustomerTransaction');
//Route::get('/customer/{userId}/transaction/{tranId}', 'API\TransactionController@getTransaction');
//Route::post('/transaction/{id}/proof-of-payment', 'API\TransactionController@updateProofOfPayment');
//Route::post('/transaction/{id}/update-status', 'API\TransactionController@updateTransactionStatus');
//Route::get('/transaction/{id}/tracking', 'API\TransactionController@getTrackingStatus');

