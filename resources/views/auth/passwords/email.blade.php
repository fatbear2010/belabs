@extends('layouts.app', ['class' => 'bg-white'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    
                     <div class="card-header bg-transparent pb-2" style="text-align: center;">
                        <img style="width: 100%; max-width: 150px;" src="{{ asset('argon') }}/img/BL3.png">
                        <div class="text-muted text-center mt-2 mb-3"><h1>Reset Password</h1></div>
                    </div>
                    @if (isset($sukses))
                    <div class="card-body px-lg-5 py-lg-5">
                        
                        <div class="text-center">
                          <h3>Halo <strong>{{$nama}}</strong> <br>Permintaan Anda Telah Kami Terima <br> Kami Telah Mengirimkan Email Konfirmasi Ke Email Gooaya Anda 
                          <br><strong>{{$email}}</strong><br>Silahkan Periksa Email Anda Untuk Melanjutkan Proses Reset Password</h3>
                          </div>

                      <br>
                      <div class="text-center" id="cnd1">
                         <button style="width: 100%" class="btn btn-dark mt-4" id="cnd">Kirim kembali Email Dalam 2:00</button>
                      </div>  
                      <div class="text-center">
                          <a href="{{ route('login') }}" class="text-light"><button style="width: 100%" class="btn btn-danger mt-4">Kembali</button></a>
                      </div>    
                  </div>  
                    @else
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>Silahkan Masukkan NRP (Mahasiswa) Atau NPK (Dosen) Anda</small>
                        </div>

                        @if(isset($error))
                             
                                    <span class="invalid-feedback text-center" style="display: block;" role="alert">
                                        <strong>{{ $error }}</strong>
                                    </span>
                                    <br>
                                @endif

                        <form role="form" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class=icofont-user></i></span>
                                    </div>
                                    <input class="form-control" placeholder="NRP / NPK" type="text" name="nrpnpk"  required autofocus>
                                </div>
                               
                            </div>
                            <div class="text-center">
                                <button type="submit" style="width: 100%" class="btn btn-fik my-4">Reset Password</button>
                            </div>
                        </form>
                         <div class="text-center">
                                <a href="{{ route('login') }}" class="text-light"> <button style="width: 100%" type="submit" class="btn btn-danger">Batalkan</button> </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        var minutes1 = 90;
        var second1 = 0;
        var x = setInterval(function() {
            var distance = minutes1-second1;
            var minutes = Math.floor(distance / 60 );
            var seconds = Math.floor(distance % 60 );if(seconds < 10){seconds = "0" + seconds;}
            document.getElementById("cnd").innerHTML ="Kirim Kembali Email Dalam "+ minutes + ":" + seconds;
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("cnd1").innerHTML = " <a href=\"{{ url('resendps/'.$nrpnpk) }}\" class=\"text-light\"><button style=\"width: 100%\" class=\"btn btn-success mt-4\" >Kirim kembali Email</button></a>";
            }
            second1++;
        }, 1000);
    </script>
@endsection
