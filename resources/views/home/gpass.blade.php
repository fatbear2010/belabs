
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
              <h1> <i class="icofont-ui-password"></i> Ganti Password</h1>
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
          <span class="alert-inner--text">Password Lama Salah</a></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          </div>
          @elseif(session('status') == 2)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="icofont-error"></i></span>
          <span class="alert-inner--text">Password Baru Tidak Sama</span>
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

                        <form method="get" action="{{ url('profil/pgantipassword') }}" autocomplete="off">
                            @csrf

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="pass3">Password Lama </label>
                                    <input minlength="8" type="password" name="pass3" id="pass3" class="form-control" required autofocus >
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="pass1">Password Baru </label>
                                    <input minlength="8" type="password" name="pass1" id="pass1" class="form-control" >
                                </div>
                                 <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="pass2">Ulangi Password Baru</label>
                                    <input minlength="8" type="password" name="pass2" id="pass2" class="form-control" >
                                </div>

                                <div class="text-center">
                                    <button type="submit" style="width: 100%;" class="btn btn-success mt-4">Ganti Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        
</div>


@endsection