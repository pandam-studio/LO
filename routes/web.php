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

Route::get('/', 'Monitoring@index');

Route::get('/home', 'HomeController@index');
Route::get('/laporan', 'HomeController@laporan');
Route::get('/pengajuan', 'HomeController@pengajuan')->name('home');
Route::post('/pengajuan/cekAlumni', 'HomeController@cekAlumni');
Route::post('/pengajuan/store', 'HomeController@store')->name('store');

Auth::routes();

Route::get('/home', 'HomeController@index');
