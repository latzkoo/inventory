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

    Route::group(['prefix' => 'cikkek'], function () {
        Route::get('/', [
            'uses' => 'ProductController@get'
        ]);
    });

    Route::group(['prefix' => 'raktarak'], function () {
        Route::get('/', [
            'uses' => 'InventoryController@get'
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

    Route::group(['prefix' => 'felhasznalok'], function () {

        Route::post('/update', [
            'uses' => 'UserController@update'
        ]);
        Route::get('/add', [
            'uses' => 'UserController@create'
        ]);
        Route::get('/edit', [
            'uses' => 'UserController@edit'
        ]);
        Route::get('/delete/{id}', [
            'uses' => 'UserController@delete'
        ]);
        Route::post('/', [
            'uses' => 'UserController@insert'
        ]);
        Route::get('/', [
            'uses' => 'UserController@get'
        ]);
    });

    Route::get('/jelszomodositas', [
        'uses' => 'UserController@updatePassword'
    ]);

    Route::get('/adatmodositas', [
        'uses' => 'UserController@settings'
    ]);

    Route::get('/', [
        'uses' => 'MainController@index'
    ]);

});
