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
    return view('auth/login');
});
Route::get('trymail','App\Http\Controllers\MailController@sendVerificarionMail');
Route::post('/vcode','App\Http\Controllers\RegistrationController@aktivasi1');
Route::get('/resend/{id}', 'App\Http\Controllers\RegistrationController@aktivasi2');
Route::get('/resendps/{id}', 'App\Http\Controllers\auth\ForgotPasswordController@reset1');
Route::get('/vcodes/{vcode}', 'App\Http\Controllers\RegistrationController@aktivasi3');
Route::get('/resetpass/{vcode}', 'App\Http\Controllers\auth\ForgotPasswordController@reset2');
Route::post('/vdone', 'App\Http\Controllers\RegistrationController@aktivasi4');
Route::post('/resetfinish', 'App\Http\Controllers\auth\ForgotPasswordController@reset3');
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
	Route::resource('admin/lab','App\Http\Controllers\LabController');
	Route::resource('admin/statusjabatan','App\Http\Controllers\StatusJabatanController');
	Route::post('admin/lab/showlaboran','App\Http\Controllers\LabController@showlaboran')->name('lab.showlaboran');
	Route::resource('admin/barangdetail','App\Http\Controllers\BarangDetailController');
	Route::resource('admin/users','App\Http\Controllers\UserController');

	//::resource('category','CategoryController');

	Route::resource('barang/all','App\Http\Controllers\PinjamController');
	Route::post('barang/all','App\Http\Controllers\PinjamController@filter')->name('barang.filter');
	Route::get('barang/detail/{id}','App\Http\Controllers\PinjamController@detail')->name('barang.detail');
	Route::get('barang/detail2/{id}','App\Http\Controllers\PinjamController@detail2')->name('barang.detail2');
	Route::get('barang/jadwal/','App\Http\Controllers\PinjamController@jadwal')->name('barang.jadwal');
	Route::get('barang/tgl/','App\Http\Controllers\PinjamController@tgl')->name('barang.tgl');
	Route::post('barang/tambah/','App\Http\Controllers\PinjamController@tambah')->name('barang.tambah');

	Route::resource('lab/all','App\Http\Controllers\PinjamLabController');
	Route::post('lab/all','App\Http\Controllers\PinjamLabController@filter')->name('lab.filter');
	Route::get('lab/detail/{id}','App\Http\Controllers\PinjamLabController@detail')->name('lab.detail');
	Route::get('lab/jadwal/','App\Http\Controllers\PinjamLabController@jadwal')->name('lab.jadwal');
	Route::get('lab/tgl/','App\Http\Controllers\PinjamLabController@tgl')->name('lab.tgl');
	Route::post('lab/tambah/','App\Http\Controllers\PinjamLabController@tambah')->name('lab.tambah');

	Route::get('keranjang/clean/','App\Http\Controllers\KeranjangController@clean')->name('keranjang.clean');
	Route::get('keranjang/hapusPinjam/','App\Http\Controllers\KeranjangController@hapusPinjam')->name('keranjang.hapusPinjam');
	Route::get('keranjang/hapusBarang/','App\Http\Controllers\KeranjangController@hapusBarang')->name('keranjang.hapusBarang');
	Route::get('keranjang/keranjangdetail/','App\Http\Controllers\KeranjangController@keranjangdetail')->name('keranjang.keranjangdetail');
	Route::get('keranjang/dosen/','App\Http\Controllers\KeranjangController@dosen')->name('keranjang.dosen');
	Route::post('keranjang/checkout/','App\Http\Controllers\KeranjangController@checkout')->name('keranjang.checkout');
	Route::post('keranjang/final/','App\Http\Controllers\KeranjangController@final')->name('keranjang.final');
	Route::get('keranjang/test/','App\Http\Controllers\KeranjangController@test')->name('keranjang.test');

	Route::get('profil/gantiprofil/','App\Http\Controllers\HomeController@gantiprofil1')->name('profil.gantiprofil');
	Route::get('profil/gantipassword/','App\Http\Controllers\HomeController@gantipassword1')->name('profil.gantipassword');
	Route::get('profil/pgantiprofil/','App\Http\Controllers\HomeController@gantiprofil2')->name('profil.pgantiprofil');
	Route::get('profil/pgantipassword/','App\Http\Controllers\HomeController@gantipassword2')->name('profil.pgantipassword');

	Route::get('order/showorder/','App\Http\Controllers\HomeController@showorder')->name('order.showorder');
	Route::get('order/detail/{id}','App\Http\Controllers\HomeController@orderdetail')->name('order.detail');
});

