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

Route::get('/', 'Monitoring@index');

Route::get('/home', 'HomeController@index');
Route::get('/laporan', 'HomeController@laporan');
Route::get('/pengajuan', 'PengajuanController@index')->name('home');
Route::get('/pengajuan/cekAlumni', 'AlumniController@cekAlumni')->name('cekAlumni');
Route::post('/pengajuan/store', 'PengajuanController@store')->name('store');
Route::get('/response','PengajuanController@response')->name('response');

Route::get('pengajuan/delete/{id}', 'PengajuanController@delete');
Route::get('detail','PengajuanController@getDetail')->name('getDetail');
Route::get('find','Monitoring@findCode')->name('find');
Route::get('updateStatus','PengajuanController@updateStatus')->name('updateStatus');
Route::get('downloadPDF','PengajuanController@downloadPDF');