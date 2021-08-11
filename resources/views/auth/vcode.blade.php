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
                            <h3>Terima Kasih Telah Mengaktifkan Akun BeLabs <br> Silahkan Cek Email Gooaya Anda</h3>
                            </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
