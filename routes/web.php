<?php

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
/*
Route::get('/', function () {
    return view('home');
});
*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');

Route::get('/user', 'UserController@index');
Route::get('/user-register', 'UserController@create');
Route::post('/user-register', 'UserController@store');
Route::get('/user-edit/{id}', 'UserController@edit');

Route::resource('user', 'UserController');
Route::resource('pasien', 'PasienController');

Route::resource('dokter', 'DokterController');
Route::get('/format_dokter', 'DokterController@format');
Route::post('/dokter', 'DokterController@import');

Route::resource('antrian', 'AntrianController');


Route::get('/laporan/dokter', 'LaporanController@dokter');

// Route::get('/homes/{id}', 'HomeController@showById');



