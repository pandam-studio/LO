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
Route::get('/pengajuan', 'HomeController@pengajuan')->name('home');
Route::post('/pengajuan/cekAlumni', 'AlumniController@cekAlumni');
Route::post('/pengajuan/store', 'PengajuanController@store')->name('store');
Route::get('/response','PengajuanController@response')->name('response');

Route::get('pengajuan/delete/{id}', function($id){
    DB::delete('delete from pengajuan where Id_pengajuan = ?', [$id]);
});


