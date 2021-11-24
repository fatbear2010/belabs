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

	Route::get('admin/barangdetail/waktu/{id}','App\Http\Controllers\BarangDetailController@sesiPenggunaan')->name('barangdetail.waktu');
	Route::post('admin/barangdetail/showsesi','App\Http\Controllers\BarangDetailController@showsesi')->name('barangdetail.showsesi');
	Route::post('admin/barangdetail/storewaktu/','App\Http\Controllers\BarangDetailController@storesesi')->name('barangdetail.storewaktu');

	Route::get('admin/barangdetail/block/{id}','App\Http\Controllers\BarangDetailController@blockSesi')->name('barangdetail.block');
	Route::post('admin/barangdetail/showblock','App\Http\Controllers\BarangDetailController@showblock')->name('barangdetail.showblock');
	Route::post('admin/barangdetail/storeblock/','App\Http\Controllers\BarangDetailController@storeblock')->name('barangdetail.storeblock');

	Route::get('admin/lab/waktu/{id}','App\Http\Controllers\LabController@sesiPenggunaan')->name('lab.waktu');
	Route::post('admin/lab/showsesi','App\Http\Controllers\LabController@showsesi')->name('lab.showsesi');
	Route::post('admin/lab/storewaktu/','App\Http\Controllers\LabController@storesesi')->name('lab.storewaktu');
	
	Route::get('admin/lab/block/{id}','App\Http\Controllers\LabController@blockSesi')->name('lab.block');
	Route::post('admin/lab/showblock','App\Http\Controllers\LabController@showblock')->name('lab.showblock');
	Route::post('admin/lab/storeblock/','App\Http\Controllers\LabController@storeblock')->name('lab.storeblock');



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
	Route::get('order/batalkan/{id}','App\Http\Controllers\HomeController@orderbatal')->name('order.batal');
	Route::post('order/pbatalkan/','App\Http\Controllers\HomeController@prosesorderbatal')->name('order.pbatal');
	Route::post('order/pbatalkan2/','App\Http\Controllers\HomeController@finalbatal')->name('order.finalbatal');

	Route::get('order/ppj/{id}','App\Http\Controllers\HomeController@ordersetujuppj')->name('order.ordersetujuppj');
	Route::post('order/pppj/','App\Http\Controllers\HomeController@prosesordersetujuppj')->name('order.pppj');
	Route::post('order/pppj2/','App\Http\Controllers\HomeController@finalsetujupj')->name('order.finalsetujupj');

	Route::get('order/pl/{id}','App\Http\Controllers\HomeController@ordersetujul')->name('order.ordersetujul');
	Route::post('order/ppl/','App\Http\Controllers\HomeController@prosesordersetujul')->name('order.ppl');
	Route::post('order/ppl2/','App\Http\Controllers\HomeController@finalsetujul')->name('order.finalsetujul');

	Route::post('order/all/','App\Http\Controllers\HomeController@allorder')->name('order.all');
	Route::get('order/all/','App\Http\Controllers\HomeController@allorder')->name('order.all');

	Route::post('item/out/','App\Http\Controllers\HomeController@itemout')->name('item.out');
	Route::get('item/out/','App\Http\Controllers\HomeController@itemout')->name('item.out');

	Route::get('ambil/all/{id}','App\Http\Controllers\AmbilbalikController@ambil')->name('ambil.ambil');
	Route::post('ambil/labku/','App\Http\Controllers\AmbilbalikController@ambillab')->name('ambil.ambillab');
	Route::post('ambil/pambil/','App\Http\Controllers\AmbilbalikController@prosesambil')->name('ambil.pambil');
	Route::post('ambil/ambilfinal/','App\Http\Controllers\AmbilbalikController@finalambil')->name('ambil.ambilfinal');
	Route::get('ambil/detail/{id}','App\Http\Controllers\AmbilbalikController@ambildetail')->name('ambil.ambildetail');
	Route::get('ambil/ambildetaildosen/{id}','App\Http\Controllers\AmbilbalikController@ambildetaildosen')->name('ambil.ambildetaildosen');
	Route::post('ambil/proses/','App\Http\Controllers\AmbilbalikController@gantiambil')->name('ambil.gantiambil');
	Route::post('ambil/gantifinal/','App\Http\Controllers\AmbilbalikController@gantiambilfinal')->name('ambil.gantiambilfinal');
	Route::post('ambil/konfirmasi/','App\Http\Controllers\AmbilbalikController@konfirmasiambil')->name('ambil.konfirmasiambil');
	Route::post('ambil/konfirmasipemesanfinal/','App\Http\Controllers\AmbilbalikController@konfirmasipemesanfinal')->name('ambil.konfirmasipemesanfinal');

	Route::get('balik/all/{id}','App\Http\Controllers\AmbilbalikController@balik')->name('balik.balik');
	Route::post('balik/pbalik/','App\Http\Controllers\AmbilbalikController@prosesbalik')->name('balik.pbalik');
	Route::post('balik/balikfinal/','App\Http\Controllers\AmbilbalikController@finalbalik')->name('balik.balikfinal');
	Route::get('balik/balikdetailmhs/{id}','App\Http\Controllers\AmbilbalikController@balikdetailmhs')->name('balik.balikdetailmhs');
	Route::post('balik/prosesmhs/','App\Http\Controllers\AmbilbalikController@prosesmhs')->name('balik.prosesmhs');
	Route::post('balik/gantifinalmhs/','App\Http\Controllers\AmbilbalikController@gantibalikfinalmhs')->name('balik.gantiambilfinalmhs');
	Route::get('balik/balikdetaildosen/{id}','App\Http\Controllers\AmbilbalikController@balikdetaildsn')->name('balik.balikdetaildosen');
	Route::get('balik/balikdetaillab/{id}','App\Http\Controllers\AmbilbalikController@balikdetaillab')->name('balik.balikdetaillab');
	Route::post('balik/proseslab/','App\Http\Controllers\AmbilbalikController@proseslab')->name('balik.proseslab');
	Route::post('balik/gantifinallab/','App\Http\Controllers\AmbilbalikController@gantibalikfinallab')->name('balik.gantibalikfinallab');
});

