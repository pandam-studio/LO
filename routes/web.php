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
Route::get('/laporan', 'PengajuanController@laporan');
Route::get('/pengajuan', 'PengajuanController@index')->name('home');
Route::get('/pengajuan/cekAlumni', 'AlumniController@cekAlumni')->name('cekAlumni');
Route::post('/pengajuan/store', 'PengajuanController@store')->name('store');
Route::get('/response','PengajuanController@response')->name('response');

Route::get('pengajuan/delete/{id}', 'PengajuanController@delete');
Route::get('pengajuan/ambil', 'PengajuanController@ambil')->name('ambil');
Route::get('detail','PengajuanController@getDetail')->name('getDetail');
Route::get('find','Monitoring@findCode')->name('find');
Route::get('updateStatus','PengajuanController@updateStatus')->name('updateStatus');
Route::get('downloadPDF','PengajuanController@downloadPDF')->name('downloadPDF');

Route::get('alumni','AlumniController@index')->name('alumni');
Route::get('getAlumni','AlumniController@getAlumni')->name('getAlumni');
Route::get('/alumni/delete/{id}', 'AlumniController@delete')->name('deleteAlumni');
Route::post('/alumni/tambah','AlumniController@store')->name('tambahAlumni');


Route::get('/berkas', 'BerkasController@index')->name('berkas');
Route::get('/berkas/delete/{id}', 'BerkasController@delete')->name('deleteBerkas');
Route::post('/berkas/tambah','BerkasController@store')->name('tambahBerkas');

Route::get('adminx', 'AdminController@index')->name('admin');
Route::post('/adminx/tambah','AdminController@store')->name('tambahUser');
Route::get('/adminx/delete/{id}', 'AdminController@delete')->name('deleteUser');
Route::get('/validateEmail', 'AdminController@validateEmail');
