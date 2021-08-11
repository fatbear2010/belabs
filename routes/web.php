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
Route::get('trymail','App\Http\Controllers\MailController@sendVerificarionMail');
Route::post('/vcode','App\Http\Controllers\RegistrationController@aktivasi1');

Auth::routes(['verify' => true]);


Route::middleware('auth')->group(function() {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
	//admin
	// Route::get('/admin/kategori','App\Http\Controllers\ProfileController@kategoriIndex');
	// Route::get('/admin/kategori/create','App\Http\Controllers\ProfileController@createkategoriIndex');
	// Route::get('/admin/kategori/{idkategori}/edit','App\Http\Controllers\ProfileController@editKat');
	// Route::get('/admin/kategori/{name}','App\Http\Controllers\ProfileController@updateKat');
	
	Route::resource('admin/kategori','App\Http\Controllers\KatController');
	Route::resource('admin/barang','App\Http\Controllers\BarangController');
	Route::resource('admin/jabatan','App\Http\Controllers\JabatanController');
	Route::resource('admin/perbaikan','App\Http\Controllers\PerbaikanController');
	Route::resource('admin/status','App\Http\Controllers\StatusController');

	//::resource('category','CategoryController');

});

