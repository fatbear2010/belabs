@extends('layouts.app', ['class' => 'bg-white'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <!-- Table -->
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                     <div class="card-header bg-transparent pb-2" style="text-align: center;">
                        <img style="width: 100%; max-width: 150px;" src="{{ asset('argon') }}/img/BL3.png">
                        <div class="text-muted text-center mt-2 mb-3"><h1>Aktivasi Akun BeLabs</h1></div>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        @if(isset($error))
                            <span class="invalid-feedback text-center" style="display: block;" role="alert">
                                <strong>{{ $error }}</strong>
                            </span>
                            <br>
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-light"><button style="width: 100%" class="btn btn-danger mt-4">Kembali</button></a>
                            </div>        
                        @else
                        <div class="text-center text-muted mb-4">
                                <h3>Halo, {{$nama}} <br> Status Akun : {{$jabatan->nama}}</h3>
                            <small>
                                    Silahkan Lengkapi Form Dibawah ini 
                            </small>
                        </div>
                        <form role="form" method="POST" action="{{ url('/vcode') }}">
                            @csrf
                            <div class="form-group">
                                 <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icofont-user"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="NRP atau NPK" type="text" name="nrpnpk" required autofocus>
                                 </div>
                            </div>

                            <div class="text-center">
                                <button style="width: 100%" type="submit" class="btn btn-fik mt-4">Aktifkan Akun</button>
                            </div>
                        </form>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
