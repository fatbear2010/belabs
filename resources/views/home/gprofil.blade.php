
<?php use App\Http\Controllers\PinjamController; ?>
<?php use App\Http\Controllers\PinjamLabController; ?>
<?php
  function isMobile() {
      return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }
  
  ?>
@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')


<div class="container-fluid mt--7">
  <div class="row">
      <div class="col-xl-12 mb-5 mb-xl-0">


        <!--div -->
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-12 text-center">
              <h1> <i class="icofont-ui-user"></i> Ganti Profil</h1>
              <h3>Untuk Mengganti Pengaturan NPK / NRP, Nama, Email, Silahkan Menghubungi Admin</h3>
              <br>
              @if(session('status'))
          @if(session('status') == 3)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Barang Berhasil Ditambahkan Ke Keranjang</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
          @elseif(session('status') == 1)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="icofont-error"></i></span>
          <span class="alert-inner--text">Password Salah</a></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          </div>
          @elseif(session('status') == 2)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="icofont-error"></i></span>
          <span class="alert-inner--text">Beberapa Item Sudah Tidak Tersedia</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
          @endif
        @endif  

    </div>
  </div>
</div>
    <br>

 
                <div class="card bg-secondary shadow">
                    <div class="card-body" style="width:100%;">

                        <form method="get" action="{{ url('profil/pgantiprofil') }}" autocomplete="off">
                            @csrf

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="notelp">Nomor Telepon <i class="icofont-phone"></i></label>
                                    <input minlength="10" type="text" name="notelp" id="notelp" class="form-control" required autofocus value="{{auth()->user()->notelp}}">
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="line">Line ID <i class="icofont-line-messenger"></i></label>
                                    <input minlength="5" type="text" name="line" id="line" class="form-control" value="{{auth()->user()->lineId}}">
                                </div>
                                @if(auth()->user()->jabatan1()->nama != "Mahasiswa")
                                <div>
                                  <label class="form-control-label">Pengaturan Email</label>
                                  <div class="row" style="margin: 0px 0px 10px 20px;">
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" name="cb1" id="customSwitch1" value="1" 
                                      @if($emailku->buat==1)checked="" @endif >
                                      <label class="custom-control-label" for="customSwitch1">Terima Email Saat Pesanan Yang Berkaitan Dengan Anda Dibuat</label>
                                    </div>
                                  </div>
                                  <div class="row" style="margin: 0px 0px 10px 20px;">
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" name="cb2" id="customSwitch2"value="1"   @if($emailku->batal==1)checked="" @endif>
                                      <label class="custom-control-label" for="customSwitch2">Terima Email Saat Pesanan Yang Berkaitan Dengan Anda Dibatalkan</label>
                                    </div>
                                  </div>
                                   <div class="row" style="margin: 0px 0px 10px 20px;">
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" name="cb3" id="customSwitch3" value="1"  @if($emailku->setuju==1)checked="" @endif>
                                      <label class="custom-control-label" for="customSwitch3">Terima Email Anda Menyetujui Pesanan</label>
                                    </div>
                                  </div>
                                  <div class="row" style="margin: 0px 0px 10px 20px;">
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" name="cb4" id="customSwitch4" value="1"  @if($emailku->ambil==1)checked="" @endif>
                                      <label class="custom-control-label" for="customSwitch4">Terima Email Pesanan Yang Berkaitan Dengan Anda Diambil</label>
                                    </div>
                                  </div>
                                   <div class="row" style="margin: 0px 0px 10px 20px;">
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input" name="cb5" id="customSwitch5" value="1" @if($emailku->kembalikan==1)checked="" @endif>
                                      <label class="custom-control-label" for="customSwitch5">Terima Email Pesanan Yang Berkaitan Dengan Anda Dikembalikan</label>
                                    </div>
                                  </div>
                                </div>
                                @endif
                                 <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="pass">Masukkan Password</label>
                                    <input minlength="5" type="password" name="pass" id="pass" class="form-control" >
                                </div>


                                <div class="text-center">
                                    <button type="submit" style="width: 100%;" class="btn btn-success mt-4">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        



@endsection