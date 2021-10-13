
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
    
<div class="card-body px-lg-5 py-lg-5">
 
                <div class="card bg-secondary shadow">
                    <div class="card-body">

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
        
</div>


@endsection