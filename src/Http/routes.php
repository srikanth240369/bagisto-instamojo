<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('instamojo/standard')->group(function () {

        Route::get('/redirect', 'Srikanth\Instamojo\Http\Controllers\StandardController@redirect')->name('instamojo.standard.redirect');

        Route::post('/post-data', 'Srikanth\Instamojo\Http\Controllers\StandardController@postdata')->name('instamojo.standard.post-data');

        Route::get('/success', 'Srikanth\Instamojo\Http\Controllers\StandardController@success')->name('instamojo.standard.success');

        Route::get('/cancel', 'Srikanth\Instamojo\Http\Controllers\StandardController@cancel')->name('instamojo.standard.cancel');
    });
});

Route::get('instamojo/standard/ipn', 'Srikanth\Instamojo\Http\Controllers\StandardController@ipn')->name('instamojo.standard.ipn');

Route::post('instamojo/standard/ipn', 'Srikanth\Instamojo\Http\Controllers\StandardController@ipn')->name('instamojo.standard.ipn');
