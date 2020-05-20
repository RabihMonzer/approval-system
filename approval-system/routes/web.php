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

Route::get('/home', 'HomeController@index')->name('home');

// Routes for Materials
Route::get('/materials', 'MaterialController@index')->name('materials.index');
Route::get('/materials/create', 'MaterialController@create')->name('materials.create');
Route::get('/materials/{material}', 'MaterialController@show')->name('materials.show');
Route::get('/materials/{material}/edit', 'MaterialController@edit')->name('materials.edit');
Route::post('/materials', 'MaterialController@store')->name('materials.store');
Route::put('/materials/approve/{material}', 'MaterialController@approve')->name('material.approve');
Route::put('/materials/decline/{material}', 'MaterialController@decline')->name('material.decline');
Route::put('/materials/{material}', 'MaterialController@update')->name('materials.update');
Route::delete('/materials/{material}', 'MaterialController@destroy')->name('materials.destroy');

// Routes For Material Types
Route::get('/material-types', 'MaterialTypeController@index')->name('material-types.index');
Route::get('/material-types/create', 'MaterialTypeController@create')->name('material-types.create');
Route::get('/material-types/{materialType}', 'MaterialTypeController@show')->name('material-types.show');
Route::get('/material-types/{materialType}/edit', 'MaterialTypeController@edit')->name('material-types.edit');
Route::post('/material-types', 'MaterialTypeController@store')->name('material-types.store');
Route::put('/material-types/{materialType}', 'MaterialTypeController@update')->name('material-types.update');
Route::delete('/material-types/{materialType}', 'MaterialTypeController@destroy')->name('material-types.destroy');
