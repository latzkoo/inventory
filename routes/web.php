<?php

Route::get('/belepes', [
    'uses' => 'Auth\LoginController@showLoginForm',
    'as' => 'login'
]);

Route::post('/login', [
    'uses' => 'Auth\LoginController@login'
]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/kilepes', [
        'uses' => 'Auth\LoginController@logout'
    ]);

    /**
     * Beszerzés
     */
    Route::group(['prefix' => 'beszerzes'], function () {
        Route::get('/add', [
            'uses' => 'PurchaseController@create',
            'as' => 'purchase.create'
        ]);
        Route::post('/update/{id}', [
            'uses' => 'PurchaseController@update',
            'as' => 'purchase.update'
        ]);
        Route::get('/edit/{id}', [
            'uses' => 'PurchaseController@edit',
            'as' => 'purchase.edit'
        ]);
        Route::get('/delete/{id}', [
            'uses' => 'PurchaseController@delete',
            'as' => 'purchase.delete'
        ]);
        Route::post('/', [
            'uses' => 'PurchaseController@insert',
            'as' => 'purchase.insert'
        ]);
        Route::get('/', [
            'uses' => 'PurchaseController@get',
            'as' => 'purchase'
        ]);
    });

    /**
     * Partnerek
     */
    Route::group(['prefix' => 'partnerek'], function () {
        Route::get('/add', [
            'uses' => 'PartnerController@create',
            'as' => 'partner.create'
        ]);
        Route::post('/update/{id}', [
            'uses' => 'PartnerController@update',
            'as' => 'partner.update'
        ]);
        Route::get('/edit/{id}', [
            'uses' => 'PartnerController@edit',
            'as' => 'partner.edit'
        ]);
        Route::get('/delete/{id}', [
            'uses' => 'PartnerController@delete',
            'as' => 'partner.delete'
        ]);
        Route::post('/', [
            'uses' => 'PartnerController@insert',
            'as' => 'partner.insert'
        ]);
        Route::get('/', [
            'uses' => 'PartnerController@get',
            'as' => 'partner.list'
        ]);
    });

    Route::group(['prefix' => 'cikkek'], function () {
        Route::get('/add', [
            'uses' => 'ProductController@create',
            'as' => 'product.create'
        ]);
        Route::post('/update/{id}', [
            'uses' => 'ProductController@update',
            'as' => 'product.update'
        ]);
        Route::get('/edit/{id}', [
            'uses' => 'ProductController@edit',
            'as' => 'product.edit'
        ]);
        Route::get('/delete/{id}', [
            'uses' => 'ProductController@delete',
            'as' => 'product.delete'
        ]);
        Route::get('/get/{id}', [
            'uses' => 'ProductController@getById',
            'as' => 'product.get'
        ]);
        Route::post('/item', [
            'uses' => 'ProductController@getNewItem',
            'as' => 'purchase.newitem'
        ]);
        Route::post('/', [
            'uses' => 'ProductController@insert',
            'as' => 'product.insert'
        ]);
        Route::get('/', [
            'uses' => 'ProductController@get',
            'as' => 'product.list'
        ]);
    });

    /**
     * Raktárak
     */
    Route::group(['prefix' => 'raktarak'], function () {
        Route::get('/add', [
            'uses' => 'InventoryController@create',
            'as' => 'inventory.create'
        ]);
        Route::post('/update/{id}', [
            'uses' => 'InventoryController@update',
            'as' => 'inventory.update'
        ]);
        Route::get('/edit/{id}', [
            'uses' => 'InventoryController@edit',
            'as' => 'inventory.edit'
        ]);
        Route::get('/delete/{id}', [
            'uses' => 'InventoryController@delete',
            'as' => 'inventory.delete'
        ]);
        Route::post('/', [
            'uses' => 'InventoryController@insert',
            'as' => 'inventory.insert'
        ]);
        Route::get('/', [
            'uses' => 'InventoryController@get',
            'as' => 'inventory.list'
        ]);
    });

    Route::group(['prefix' => 'beszerzes'], function () {
        Route::get('/', [
            'uses' => 'PurchaseController@get'
        ]);
    });

    Route::group(['prefix' => 'ertekesites'], function () {
        Route::get('/', [
            'uses' => 'SaleController@get'
        ]);
    });

    /**
     * Felhasználók
     */
    Route::group(['prefix' => 'felhasznalok'], function () {

        Route::get('/add', [
            'uses' => 'UserController@create',
            'as' => 'user.create'
        ]);
        Route::post('/update/{id}', [
            'uses' => 'UserController@update',
            'as' => 'user.update'
        ]);
        Route::get('/edit/{id}', [
            'uses' => 'UserController@edit',
            'as' => 'user.edit'
        ]);
        Route::get('/delete/{id}', [
            'uses' => 'UserController@delete',
            'as' => 'user.delete'
        ]);
        Route::post('/', [
            'uses' => 'UserController@insert',
            'as' => 'user.insert'
        ]);
        Route::get('/', [
            'uses' => 'UserController@get',
            'as' => 'user.list'
        ]);
    });

    Route::get('/jelszomodositas', [
        'uses' => 'UserController@editPassword',
        'as' => 'user.password.edit'
    ]);

    Route::post('/jelszomodositas', [
        'uses' => 'UserController@updatePassword',
        'as' => 'user.password.update'
    ]);

    Route::get('/adatmodositas', [
        'uses' => 'UserController@settings'
    ]);

    Route::get('/', [
        'uses' => 'MainController@index'
    ]);

});
