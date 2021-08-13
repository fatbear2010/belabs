@extends('layouts.app', ['class' => 'bg-white'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-header bg-transparent pb-2" style="text-align: center;">
                        <img style="width: 100%; max-width: 150px;" src="{{ asset('argon') }}/img/BL3.png">
                        <div class="text-muted text-center mt-2 mb-3"><h1>Selamat Datang Di BeLabs</h1></div>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>
                                    Silahkan Login Menggunakan <strong>NRP (Mahasiswa) / NPK (Dosen)</strong> Dan <strong>Password</strong> Anda   
                            </small>
                        </div>

                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            @if (isset($error))
                                    <span class="invalid-feedback text-center" style="display: block;" role="alert">
                                        <strong>{{ $error }}</strong>
                                    </span>
                                    <br>
                                @endif

                            <div class="form-group{{ $errors->has('nrpnpk') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icofont-user"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="NRP atau NPK" type="text" name="nrpnpk" required autofocus>
                                </div>
                           
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" type="password"  required>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                          
                            <div class="text-center">
                                <button style="width: 100%" type="submit" class="btn btn-fik ">Masuk</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-transparent pb-2" style="text-align: center;">
                         <div class="row">
		                    <div class="col-6 text-center">
		                        @if (Route::has('password.request'))
		                            <a href="{{ route('password.request') }}" class="text-light">
		                                <button style="width: 100%" class="btn btn-danger my-2">Lupa Password</button>
		                            </a>
		                        @endif
		                    </div>
		                    <div class="col-6 text-center">
		                        <a href="{{ route('register') }}" class="text-light">
		                            <button style="width: 100%" class="btn btn-dark my-2">Aktivasi Akun</button>
		                        </a>
		                    </div>
		                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
