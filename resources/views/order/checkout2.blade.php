<?php use App\Http\Controllers\PinjamController; ?>
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
      <h1> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Checkout</h1>
      <br>
    </div>
  </div>
</div>
<br>
<div style="margin-left: auto; margin-right: auto;">
    <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Identitas Pemesan</h2><span class="font-weight-light"></span>
        </div>
        <div class="row" style="margin: 5px 10px 5px 10px;">
            <div class="col-lg-2 text-center" >
              @if(auth()->user()->jabatan1()->nama == "Mahasiswa")
              <img alt="" style="max-width:100%; max-height:150px; " onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"  src="https://my.ubaya.ac.id/img/mhs/{{auth()->user()->nrpnpk}}_m.jpg">
              @else
              <img alt="" style="max-width:100%; max-height:150px;" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'" src="https://my.ubaya.ac.id/img/krywn/{{auth()->user()->nrpnpk}}_m.jpg">
              @endif
          </div>
            <div class="col-lg-10 text-left table-responsive">
                <table class="table wrap">
                  <tr><td >NRP/NPK</td><td><b>{{ auth()->user()->nrpnpk }}</b></td></tr>
                  <tr><td>Nama Lengkap</td><td><b>{{ auth()->user()->nama }}</b></td></tr>
                  <tr><td>Fakultas</td><td><b>{{ auth()->user()->fakultas }}</b></td></tr>
                  <tr><td>Jabatan</td><td><b>{{auth()->user()->jabatan1()->nama}}</b></td></tr>
                  <tr><td>Email</td><td><b>{{ auth()->user()->email }}</b></td></tr>
                  <tr><td>No Telp</td><td><b>{{ auth()->user()->notelp }}</b></td></tr>
                  <tr><td>Line ID</td><td><b>{{ auth()->user()->lineid }}</b></td></tr>
              </table>
            </div>
        </div>
    </div>
    <br>
    <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Dosen Penanggungjawab</h2><span class="font-weight-light"></span>
        </div>
        <div class="row" style="margin: 5px 10px 5px 10px;">
           <div class="col-lg-2 text-center">
                      <img alt="" style="max-width:100%; max-height:150px;" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'" src="https://my.ubaya.ac.id/img/krywn/{{auth()->user()->nrpnpk}}_m.jpg">
                    </div>
                    <div class="col-md-10 text-left table-responsive">
                      <table class="table wrap" style="margin:10px;">
                        <tr><td >NRP/NPK</td><td><b>{{ auth()->user()->nrpnpk }}</b></td></tr>
                        <tr><td>Nama Lengkap</td><td><b>{{ auth()->user()->nama }}</b></td></tr>
                        <tr><td>Fakultas</td><td><b>{{ auth()->user()->fakultas }}</b></td></tr>
                      </table>
                    </div>
        </div>
    </div>
    <br>
    <div class="row text-center" id="keranjang13" style="margin-left: auto; margin-right: auto;">
     <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Item Yang Dipesan</h2><span class="font-weight-light"></span>
        </div>
        <div class="row" style="margin: 5px 10px 5px 10px;">
           @foreach(session('cart3') as $item)
                  <?php $gambar = $item['gambar'];?>
                  @if($item['tipe'] == "barang")
                  @if(isMobile())
                  <div id="d{{$item['id']}}" class="col-lg-12 overflow-auto" style="margin-bottom:10px; min-width: 100px; ">
                        <div class="card" style=" min-width: 100px;">
                            <div style="position:relative;  overflow: hidden; height:100px; ">
                                <img style="top: 50%" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                            </div>
                            <div style="padding:10px 10px 0px 10px; text-align:left;">     
                              <h4 class="card-title wrap">{{$item['merk']." ".$item['nama']}}</h4>
                            </div>
                            <div style="text-align:left; padding:0px 10px 0px 10px;">
                                <h5>{{$item['barang']}}<br>{{$item['kat']}}<br><br>{{$item['lab']}}<br>{{$item['fakultas']}}</h5>
                            </div>
                            <div class="row" style="margin-left: 10px;">
                            </div>
                            <div style="margin-top: auto; margin-bottom: auto;  text-align:left; min-width: 200px;  ">
                                <div style="padding:10px;">
                                    <h3>Jadwal Peminjaman</h3>
                                    <?php $hitung = 0; ?>
                                    @foreach($item['pinjam'] as $pj)
                                    <div id="f{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}" class="btn-group" role="group" style="margin-bottom:5px;" id="e{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}">
                                        <button class="btn-sm btn-fik"> 
                                            {{$pj['tgl']}}<br>{{$pj['mulai']." - ".$pj['selesai']}} </button> 
                                    </div>  
                                    <?php $hitung++; ?>
                                    @endforeach 
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div id="d{{$item['id']}}" class="col-lg-12 " style="margin-bottom:10px; min-width: 350px; max-height: 90%;">
                        <div class="card rounded" style=" min-width: 380px;">
                            <div style="margin-left: 1px;" class="row rounded-top" >
                                <div style="position:relative;  overflow: hidden; height:200px; width:200px; ">
                                    <img style="position: absolute; margin-left: -75%; width:300px;" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                                </div>
                                <div style="padding:15px; text-align:left; width: 40%; ">     
                                    <h3 class="card-title wrap">{{$item['merk']." ".$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['barang']." | ".$item['kat']}}<br><br>{{$item['lab']}}<br>{{$item['fakultas']}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: auto; margin-bottom: auto;  text-align:left; ;  ">
                                    <div style="padding:15px;">
                                        <h3>Jadwal Peminjaman</h3>
                                        <div class="">
                                            <?php $hitung = 0; ?>
                                            @foreach($item['pinjam'] as $pj)
                                            <div class="col" id="e{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}">
                                                <div id="f{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}" class="btn-group" role="group" style="margin-bottom:5px;">
                                                    <button class="btn btn-fik" > 
                                                    {{$pj['tgl']." ".$pj['mulai']." - ".$pj['selesai']}} </button> 
                                                </div>  
                                            </div>
                                            <?php $hitung++; ?>
                                            @endforeach 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @elseif($item['tipe']=="lab")
                    @if(isMobile())
                    <div id="d{{$item['id']}}" class="col-lg-12 overflow-auto" style="margin-bottom:10px; min-width: 100px; ">
                        <div class="card" style=" min-width: 100px;">
                            <div style="position:relative;  overflow: hidden; height:100px; ">
                                <img style="top: 50%" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                            </div>
                            <div style="padding:10px 10px 0px 10px; text-align:left;">     
                              <h4 class="card-title wrap">{{$item['nama']}}</h4>
                            </div>
                            <div style="text-align:left; padding:0px 10px 0px 10px;">
                                <h5>{{$item['lokasi']}}<br>{{$item['fakultas']}}</h5>
                            </div>
                            <div class="row" style="margin-left: 10px;">
                            </div>
                            <div style="margin-top: auto; margin-bottom: auto;  text-align:left; min-width: 200px;  ">
                                <div style="padding:10px;">
                                    <h3>Jadwal Penggunaan</h3>
                                    <?php $hitung = 0; ?>
                                    @foreach($item['pinjam'] as $pj)
                                    <div id="f{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}" class="btn-group" role="group" style="margin-bottom:5px;" id="e{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}">
                                        <button class="btn-sm btn-fik"> 
                                            {{$pj['tgl']}}<br>{{$pj['mulai']." - ".$pj['selesai']}} </button> 
                                    </div>  
                                    <?php $hitung++; ?>
                                    @endforeach 
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div id="d{{$item['id']}}" class="col-lg-12" style="margin-bottom:10px; min-width: 350px; max-height: 90%;">
                        <div class="card rounded" style=" min-width: 380px;">
                            <div style="margin-left: 1px;" class="row rounded-top" >
                                <div style="position:relative;  overflow: hidden; height:200px; width:200px; ">
                                    <img style="position: absolute; margin-left: -75%; width:300px;" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                                </div>
                                <div style="padding:15px; text-align:left; width: 40%; ">     
                                    <h3 class="card-title wrap">{{$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['lokasi']}}<br>{{$item['fakultas']}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: auto; margin-bottom: auto;  text-align:left; ;  ">
                                    <div style="padding:15px;">
                                        <h3>Jadwal Penggunaan</h3>
                                        <div class="">
                                            <?php $hitung = 0; ?>
                                            @foreach($item['pinjam'] as $pj)
                                            <div class="col" id="e{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}">
                                                <div id="f{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}" class="btn-group" role="group" style="margin-bottom:5px;">
                                                    <button class="btn btn-fik" > 
                                                    {{$pj['tgl']." ".$pj['mulai']." - ".$pj['selesai']}} </button> 
                                                </div>  
                                            </div>
                                            <?php $hitung++; ?>
                                            @endforeach 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                    @endforeach
        </div>
    </div>
    </div>
    <br>
    <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Catatan Pemesanan</h2><span class="font-weight-light"></span>
        </div>
        <div class="row" style="margin: 5px 10px 5px 10px;">
           <div class="col-lg-12 text-left" style="margin: 10px 10px 10px 10px; min-height: 100px;">
                <h5>{{$pesan}}</h5>
            </div>
        </div>
    </div>
     <br>
      <form id="iniform" action="{{url('keranjang/final')}}" method="post"> @csrf
                    <input type="hidden" name="random" value="{{$random}}">
                    <input type="hidden" name="dosen" value="{{$dosenku}}">
                    <input type="hidden" name="pesan" value="{{$pesan}}">
                     <input type="submit" name="ok" style="width: 100%; margin-top: 10px;" id="checkout11" class="btn btn-fik" value="Checkout" >
      </form>          
                  


</div>
</div>
</div>


@endsection