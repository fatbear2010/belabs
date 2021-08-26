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
                        <div class="text-muted text-center mt-2 mb-3"><h1>Reset Password Akun BeLabs</h1></div>
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
                        @endif
                        @if(isset($done))
                            <div class="text-center text-muted mb-4">
                                <h3>Halo, {{$nama}} </h3>
                        
                            </div>
                            <span class="invalid-feedback text-center" style="display: block;" role="alert">
                                <strong>{{ $done }}</strong>
                            </span>
                            <br>
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-light"><button style="width: 100%" class="btn btn-success mt-4">Login</button></a>
                            </div>        
                        @endif
                        @if(isset($vcode))
                        <div class="text-center text-muted mb-4">
                                <h3>Halo, {{$nama}}</h3>
                            <small>
                                    Silahkan Isi Form Berikut Mereset Password Anda
                            </small>
                        </div>
                        @if(isset($error1))
                            <span class="invalid-feedback text-center" style="display: block;" role="alert">
                                <strong>{{ $error1 }}</strong>
                            </span>
                            <br>   
                        @endif
                        <form role="form" method="POST" action="{{ url('/resetfinish') }}">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="vcode" value="{{$vcode}}">
                                 <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icofont-key"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="password" type="password" required minlength="8" name="pass1" autofocus>
                                 </div>
                                 <br>
                                 <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icofont-key"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Ulangi Password" type="password" required minlength="8" name="pass2" autofocus>
                                 </div>
                            </div>

                            <div class="text-center">
                                <button style="width: 100%" type="submit" class="btn btn-fik mt-4">Reset Password</button>
                            </div>
                        </form>
                        @endif
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
@endsection
