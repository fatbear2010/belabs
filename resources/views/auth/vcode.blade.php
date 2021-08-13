@extends('layouts.app', ['class' => 'bg-white'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <!-- Table -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card bg-secondary shadow border-0">
                     <div class="card-header bg-transparent pb-2" style="text-align: center;">
                        <img style="width: 100%; max-width: 150px;" src="{{ asset('argon') }}/img/BL3.png">
                        <div class="text-muted text-center mt-2 mb-3"><h1>Aktivasi Akun BeLabs</h1></div>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        
                          <div class="text-center">
                            <h3>Halo <strong>{{$nama}}</strong> <br>Terima Kasih Telah Mengaktifkan Akun BeLabs <br> Kami Telah Mengirimkan Email Konfirmasi Ke Email Gooaya Anda 
                            <br><strong>{{$email}}</strong><br>Silahkan Periksa Email Anda Untuk Melanjutkan Proses Aktivasi</h3>
                            </div>

                        <br>
                        <div class="text-center" id="cnd1">
                           <button style="width: 100%" class="btn btn-dark mt-4" id="cnd">Kirim kembali Email Dalam 2:00</button>
                        </div>  
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-light"><button style="width: 100%" class="btn btn-danger mt-4">Kembali</button></a>
                        </div>    
                    </div>
                    
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
                document.getElementById("cnd1").innerHTML = " <a href=\"{{ url('resend/'.$nrpnpk) }}\" class=\"text-light\"><button style=\"width: 100%\" class=\"btn btn-success mt-4\" >Kirim kembali Email</button></a>";
            }
            second1++;
        }, 1000);
    </script>
@endsection
