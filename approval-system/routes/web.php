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
Route::get('/materials', 'MaterialController@index')->name('materials.index');
Route::get('/materials/create', 'MaterialController@create')->name('materials.create');
Route::get('/materials/{material}', 'MaterialController@show')->name('materials.show');
Route::get('/materials/{material}/edit', 'MaterialController@edit')->name('materials.edit');
Route::post('/materials', 'MaterialController@store')->name('materials.store');
Route::put('/materials/{material}', 'MaterialController@update')->name('materials.update');
Route::delete('/materials/{material}', 'MaterialController@destory')->name('materials.destroy');
