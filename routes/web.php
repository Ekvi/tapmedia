<?php

Route::resource('/domains', 'BadDomainController');

Route::get('/', 'ClickController@index')->name('clicks');
Route::get('/click', 'ClickController@add')->name('click');
Route::get('/clicks/get', 'ClickController@get');
Route::delete('/click/{id}/delete', 'ClickController@destroy');

Route::get('/{action}/{id}', 'StatusController@index')->name('status');

