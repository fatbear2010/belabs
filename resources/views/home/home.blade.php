@extends('layouts.app')
<?php
  function isMobile() {
      return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }
  
  ?>
@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->nama,
        'description' => __('Selamat Datang Di BeLABS, Sistem Pencatatan Peminjaman Barang Dan Penggunaan Laboratorium Universitas Surabaya'),
        'class' => 'col-lg-7'
    ]) 
     

  
    <br>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow" style=" height: 610px;">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    @if(auth()->user()->jabatan1()->nama == "Mahasiswa")
                                    <img alt="" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'" src="https://my.ubaya.ac.id/img/mhs/{{auth()->user()->nrpnpk}}_m.jpg">
                                    @else
                                    <img alt="" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'" src="https://my.ubaya.ac.id/img/krywn/{{auth()->user()->nrpnpk}}_m.jpg">
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                    <br><br><br><br><br><br><br>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="text-center">
                            <h2>
                                {{ auth()->user()->nama }}<span class="font-weight-light"></span>
                            </h2>
                            <div class="h4 font-weight-500">

                                <i class="ni location_pin mr-2"></i>{{ auth()->user()->nrpnpk }} | {{ auth()->user()->jurusan1()->namaJurusan }} <br> {{ auth()->user()->fakultas1()->namafakultas }}
                            </div>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>Jenis Akun
                            </div>
                            <div>
                                <i class="ni education_hat mr-2"></i>{{auth()->user()->jabatan1()->nama}}
                            </div>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>Kontak
                            </div>
                            <div>
                                <i class="ni education_hat mr-2"></i>Email : {{ auth()->user()->email }}
                            </div>
                             <div>
                                <i class="ni education_hat mr-2"></i>Nomor Telepon : {{ auth()->user()->notelp }} | Line ID : {{ auth()->user()->lineId }}
                            </div>
                            <hr class="my-4" />
                            <div class="row">
                                <div class="col">
                                    <a href="{{url('profil/gantiprofil')}}" style="width:100%; margin-bottom:10px;" class="btn btn-fik">Ganti Profil</a>
                                </div>
                                <div class="col">
                                    <a href="{{url('profil/gantipassword')}}"  style="width:100%; margin-bottom:10px;" class="btn btn-fik">Ganti Password</a>
                                </div>
                            </div>
                                 @if(auth()->user()->jabatan1()->nama != "Mahasiswa")
                                <div class="row">
                                    <div class="col">
                                   <a href="{{url('order')}}"style="width:100%; margin-bottom:10px;" class="btn btn-fik">Lihat Pesanan Yang Berkaitan Dengan Anda</a>
                               </div>
                               @endif
                                </div>
                        </div>
                    </div>
                </div>
            </div>
           <div class="col-xl-8 order-xl-10 mb-7 mb-xl-0">
                    <div class="row justify-content-center">
                        <div class="col-xl-4 sm-12" style="margin-bottom: 10px;">
                            <div class="card card-stats">
                                <div class="card-body">    
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Total Pesanan</h5>
                                            <span class="h2 font-weight-bold mb-0">{{$total[0]->jumlah}}</span>
                                        </div>
                                        <div class="col-auto">
                                          <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                                              <i class="icofont-ui-love"></i>
                                          </div>
                                      </div>
                                      </div>
                                      <p class="mt-3 mb-0 text-sm">
                                        
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 sm-12" style="margin-bottom: 10px;">
                            <div class="card card-stats">
                                <div class="card-body">    
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Total Pesanan Selesai</h5>
                                            <span class="h2 font-weight-bold mb-0">{{$totalpasif[0]->jumlah}}</span>
                                        </div>
                                        <div class="col-auto">
                                          <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                                              <i class="icofont-check"></i>
                                          </div>
                                      </div>
                                      </div>
                                      <p class="mt-3 mb-0 text-sm">
                                     
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 sm-12" style="margin-bottom: 10px;">
                            <div class="card card-stats">
                                <div class="card-body">    
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Total Pesanan Aktif</h5>
                                            <span class="h2 font-weight-bold mb-0">{{$totalaktif[0]->jumlah}}</span>
                                        </div>
                                        <div class="col-auto">
                                          <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                                              <i class="icofont-warning-alt"></i>
                                          </div>
                                      </div>
                                      </div>
                                      <p class="mt-3 mb-0 text-sm">
                                       
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="card card-profile shadow " style="width: 98%; height: 480px;">
                          <div class="card-header"><h2>
                                 <div class="row">
                                    <div class="col-md-12">
                                        Pesanan Aktif Saya<span class="font-weight-light"></span>
                                    </div>
                                </div>  
                            </h2></div>
                        <div class="overflow-auto">
                        <?php for($i = 0; $i<count($update1); $i++) {  ?>
                        <div class="row" style="margin: 20px 20px 5px 20px;" >
                          <div class="col-md-9" >
                            <table>
                                <tr>
                                    <td>
                                        <h4>No. Pesanan {{$update1[$i]->order}} | {{date("d-m-Y H:i:s",strtotime($update1[$i]->tanggal))}} </h4>
                                    </td>
                                    <td>
                                      <div class="dropdown" >
                                          <p class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="showorder({{$update1[$i]->order}});">
                                          </p>
                                          <div id="a{{$update1[$i]->order}}" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 350px;">
                                            <div>
                                             <table><tr><td style="padding-left: 20px;"><div class="spinner-border text-fik" role="status"></div></td><td style="padding-left: 10px;"><h3>Loading....</h3></td></tr></table>
                                            </div> 
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                            <p class="card-text">{{$update1[$i]->nama}}</p>
                          </div>
                          
                          <div class="col-md-3">
                              <a href="{{url('order/detail/'.$update1[$i]->order)}}" class="btn btn-fik">Lihat Detail Pesanan</a>
                          </div> 
                          </div>
                        <?php } ?>              
                        </div></div>
                    </div>
           </div>
        </div>
        @if(isMobile())
        <div class="row justify-content-center" style="margin-top: -70px;">
        @else
         <div class="row justify-content-center" style="margin-top: 10px;">
        @endif
            <div class="card card-profile shadow " style="width: 98%; height: 410px;">
              <div class="card-header"><h2>
                <div class="row">
                    <div class="col-md-12">
                        Semua Pesanan Saya<span class="font-weight-light"></span>
                    </div>
                </div>
            </h2></div>
            <div class="overflow-auto">
            <?php for($i = 0; $i<count($pesanan); $i++) {  ?>
                <div class="row" style="margin: 20px 20px 5px 20px;">
                    <div class="col-md-9" >
                            <table>
                                <tr>
                                    <td>
                                         <h3>No. Pesanan {{$pesanan[$i]->idorder}} </h3>
                                    </td>
                                    <td>
                                      <div class="dropdown" >
                                          <p class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="showorder1({{$pesanan[$i]->idorder}});">
                                          </p>
                                          <div id="b{{$pesanan[$i]->idorder}}" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 350px;">
                                            <div>
                                             <table><tr><td style="padding-left: 20px;"><div class="spinner-border text-fik" role="status"></div></td><td style="padding-left: 10px;"><h3>Loading....</h3></td></tr></table>
                                            </div> 
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr><td><h4>Pesanan Dibuat  : {{date("d-m-Y H:i:s",strtotime($pesanan[$i]->tanggal))}} </h4></td></tr>
                        </table>
                        
                          </div>
                    <div class="col-md-3">
                    <a href="{{url('order/detail/'.$pesanan[$i]->idorder)}}" class="btn btn-fik">Lihat Detail Pesanan</a>
                </div> 
            </div> 
              <?php } ?>             
        </div></div>
    </div>
        
    </div>
    <script type="text/javascript">
        function showorder(a)
        {
            $.ajax({
            type: "GET",
            url: "{{url('order/showorder')}}",
            data: {ido:a},
                success: function(data) {
                    $('#a'+a).empty();
                    $('#a'+a).append(data);
                }
            });  
        }
        function showorder1(a)
        {
            $.ajax({
            type: "GET",
            url: "{{url('order/showorder')}}",
            data: {ido:a},
                success: function(data) {
                    $('#b'+a).empty();
                    $('#b'+a).append(data);
                }
            });  
        }
    </script>
@endsection
