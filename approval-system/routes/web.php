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
Route::put('/materials/{material}', 'MaterialController@update')->name('materials.update');
Route::delete('/materials/{material}', 'MaterialController@destroy')->name('materials.destroy');

// Routes for Rejected Material Logs
Route::get('/rejected-materials-log', 'RejectedMaterialLogController@index')->name('rejected-materials-log.index');
