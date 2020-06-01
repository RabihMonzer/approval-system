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

Auth::routes();


// Routes for Materials
Route::get('/materials', 'MaterialController@index')->name('materials.index');
Route::get('/materials/create', 'MaterialController@create')->name('materials.create');
Route::get('/materials/{material}', 'MaterialController@show')->name('materials.show');
Route::get('/materials/{material}/edit', 'MaterialController@edit')->name('materials.edit');
Route::post('/materials', 'MaterialController@store')->name('materials.store');
Route::put('/materials/approve/{material}', 'MaterialController@approve')->name('material.approve');
Route::delete('/materials/decline/{material}', 'MaterialController@decline')->name('material.decline');
Route::put('/materials/{material}', 'MaterialController@update')->name('materials.update');
Route::delete('/materials/{material}', 'MaterialController@destroy')->name('materials.destroy');

Route::get('/news', 'NewsController@index')->name('news.index');
Route::get('/news/create', 'NewsController@create')->name('news.create');
Route::get('/news/{news}', 'NewsController@show')->name('news.show');
Route::get('/news/{news}/edit', 'NewsController@edit')->name('news.edit');
Route::post('/news', 'NewsController@store')->name('news.store');
Route::put('/news/approve/{news}', 'NewsController@approve')->name('news.approve');
Route::delete('/news/reject/{news}', 'NewsController@reject')->name('news.reject');
Route::put('/news/{news}', 'NewsController@update')->name('news.update');
Route::delete('/news/{news}', 'NewsController@destroy')->name('news.destroy');


// Routes for Rejected Material Logs
Route::get('/rejected-news-log', 'RejectedNewsLogController@index')->name('rejected-news-log.index');

// APIs
Route::prefix('api')->group(function () {

    Route::get('/materials/{material}', 'MaterialAPIController@show')->name('material-api.show');
    Route::get('/materials', 'MaterialAPIController@index')->name('material-api.index');
    Route::post('/materials', 'MaterialAPIController@store')->name('material-api.store');
    Route::put('/materials/{material}', 'MaterialAPIController@update')->name('material-api.update');
    Route::delete('/materials/{material}', 'MaterialAPIController@destroy')->name('material-api.destroy');
    Route::delete('/materials/decline/{material}', 'MaterialAPIController@decline')->name('material-api.decline');
    Route::put('/materials/approve/{material}', 'MaterialAPIController@approve')->name('material-api.approve');

});
