<?php use App\Http\Controllers\PinjamController; ?>
<?php use App\Http\Controllers\KeranjangController; ?>
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
      <h1>Detail Pesanan</h1>
      <h1>Nomor Pesanan : {{$orderku[0]->idorder}}</h1>
      <h3>Waktu Pesanan Dibuat : {{$orderku['0']->tanggal}}</h3>

       @if(session('status'))
          @if(session('status') == 1)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Item Berhasil Dibatalkan</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
        @elseif(session('status') == 4)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Persetujuan Berhasil Disimpan</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
          @elseif(session('status') == 3)
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
      <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('order/batalkan/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-danger">Batalkan Pesanan</a>
      <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('order/ppj/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-dark">Setujui Pesanan (Penanggungjawab)</a>
      <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('order/pl/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-light">Setujui Pesanan (Laboran/Kalab)</a>
      <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('order/batalkan/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-primary">Pengambilan Pesanan (Pemesan)</a>
      <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('order/batalkan/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-info">Pengambilan Pesanan (Laboran/Kalab)</a>
      <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('order/batalkan/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-success">Pengembalian Pesanan (Pemesan) </a>
      <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('order/batalkan/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-warning">Pengambilan Pesanan (Laboran/Kalab)</a>
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
                  <tr><td>Jurusan , <br> Fakultas</td><td><b>{{ auth()->user()->jurusan1()->namaJurusan}} <br> {{auth()->user()->fakultas1()->namafakultas }}</b></td></tr>
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
                      <table class="table wrap">
                        <tr><td>NRP/NPK</td><td><b>{{ $dosenpj[0]->nrpnpk }}</b></td></tr>
                        <tr><td>Nama Lengkap</td><td><b>{{ $dosenpj[0]->nama }}</b></td></tr>
                        <tr><td>Jurusan,Fakultas</td><td><b>{{ KeranjangController::jurusan($dosenpj[0]->jurusan)}}</b></td></tr>
                      </table>
                    </div>
        </div>
    </div>
    <br>
    <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Riwayat Pesanan</h2><span class="font-weight-light"></span>
        </div>
        <div class="row">
            <div class="col">
                <div class="timeline p-4 block mb-4">
<?php for ($i=count($status)-1; $i > -1 ; $i--) { ?>        
                    <div class="tl-item ">
                        <div class="tl-dot b-fik"></div>
                        <div class="tl-content">
                            <div class="">
                                <h4>{{date("d-m-Y H:i:s" , strtotime($status[$i]->tanggal))}} <br><b>{{$status[$i]->nama}}</b></h4>
                                <h5>{{KeranjangController::cariorang($status[$i]->pic)}}</h5>
                            </div>
                        </div>
                    </div>       
<?php } ?>        
                </div>
            </div>
        </div>
    </div>  
    <br>
   <div class="row text-center" id="keranjang13" style="margin-left: auto; margin-right: auto;">
     <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Item Yang Dipesan</h2>
            <button style="margin-bottom:10px;" class="btn-sm btn-fik">Sedang Diproses</button>
            <button style="margin-bottom:10px;" class="btn-sm btn-success">Disetujui</button>
            <button style="margin-bottom:10px;" class="btn-sm btn-danger">Tidak Dietujui/Batal</button>
            <button style="margin-bottom:10px;" class="btn-sm btn-primary">Telah Diambil</button>
            <button style="margin-bottom:10px;" class="btn-sm btn-info">Telah Dikembalikan</button>
            <button style="margin-bottom:10px;" class="btn-sm btn-ligth">Item Bermasalah</button>
        </div>
           @foreach($keranjang as $item)
                <div class="row" style="margin: 5px 10px 5px 10px;">
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
                                <h5>{{$item['barang']}}<br>{{$item['kat']}}<br><br>{{$item['lab']}}<br>{{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                            </div>
                            <div class="row" style="margin-left: 10px;">
                                <a style="margin-bottom:5px; margin-right: 5px;" href="{{ url('barang/detail2/'.$item['id']) }}" class="btn-sm btn-dark"> <i class="icofont-eye-alt"></i> Cek Barang</a>
                            </div>
                            <div style="margin-top: auto; margin-bottom: auto;  text-align:left; min-width: 200px;  ">
                                <div style="padding:10px;">
                                    <h3>Jadwal Peminjaman</h3>
                                    <?php $hitung = 0; ?>
                                     <div class="accordion" id="accordionExample" style="width:100%">
                                    @foreach($item['pinjam'] as $pj)
                                    <div class="card">
                                   
                                        <button 
                                        @if($pj['status'] == 2) class="btn-sm btn-danger text-left " 
                                        @elseif($pj['checkout'] != "") class="btn-sm btn-info text-left " 
                                        @elseif($pj['checkin'] != "") class="btn-sm btn-primary text-left " 
                                        @elseif($pj['status'] == 1) class="btn-sm btn-success text-left " 
                                        @else class="btn-sm btn-fik text-left " @endif

                                        type="button" data-toggle="collapse" data-target="#z{{$hitung.$item['id']}}" aria-expanded="true" aria-controls="z{{$hitung.$item['id']}}" style="width:100%;">
                                        <div class="row"><div class="col-10">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}} </div><div class="col-1 text-right"><i class="icofont-caret-down"></i></div></div>
                                           
                                        </button>
                                    

                                    <div id="z{{$hitung.$item['id']}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="width:100%; padding-left: 10px;" >
                                        <br>
                                        <div class="row">
                                            <div class="col-4"><h5>Checkin</h5></div>
                                            <div class="col-8"><h5>{{$pj['checkin']}}</h4></div>
                                            <div class="col-4"><h5>Checkout</h5></div>
                                            <div class="col-8"><h5>{{$pj['checkout']}}</h4></div>
                                            <div class="col-4"><h5>Catatan</h5></div>
                                            <div class="col-8"><h5>{{$pj['masalah']}}</h5></div>
                                            <div class="col-4"><h5>Dosen Penanggungjawab</h5></div>
                                            <div class="col-8"><h5>
                                                @if($pj['sdosen'] == 2) Tidak Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @elseif($pj['sdosen'] == 1) Sudah Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h5></div>
                                            <div class="col-4"><h5>Laboran / Kepala Laboratorium</h5></div>
                                            <div class="col-8"><h5>
                                                @if($pj['skalab'] == 2) Tidak Disetujui {{$pj['statuskalab']}} - {{PinjamController::dosen1($pj['skalab'])->nama}}
                                                @elseif($pj['skalab'] == 1) Sudah Disetujui {{$pj['statusKalab']}} - {{PinjamController::dosen1($pj['statusKalab'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h5></div>
                                            <div class="col-4"><h5>Lainnya</h5></div>
                                            <div class="col-8"><h5>{{$pj['keterangan']}}</h5></div>
                                        </div>
                                        <br>
                                    </div>
                                  </div>
                                    <?php $hitung++; ?>
                                    @endforeach 
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <?php $hitung = 0;?>
                    <div id="d{{$item['id']}}" class="col-lg-12" style="margin-bottom:10px; min-width: 350px; max-height: 90%;">
                        <div class="card rounded" style=" min-width: 380px;">
                            <div style="margin-left: 1px;" class="row rounded-top" >
                                
                                <div class="col-3 md-4" style="position:relative;  overflow: hidden; min-height:200px; width:200px; ">
                                    <img style="position: absolute; margin-left: -50%; width:100%; min-height:200px;" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                                </div>
                                <div class="col-9 md-6">
                                <div style="text-align:left;margin-top: 20px;   ">     
                                    <h3 class="card-title wrap">{{$item['merk']." ".$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['barang']." | ".$item['kat']}}<br><br>{{$item['lab']}}<br>{{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                                        </div>
                                    </div>
                                    <a style="margin-bottom:5px;" href="{{ url('barang/detail2/'.$item['id']) }}" class="btn btn-dark"> <i class="icofont-eye-alt"></i> Cek Barang</a>
                                </div>
                                </div>
                                <div class="col-12">
                                <div style="margin-top: auto; margin-bottom: auto;  text-align:left;  ">
                                    <div style="padding:15px;">
                                        <h3>Jadwal Penggunaan</h3>
                                        <div class="accordion" id="accordionExample" style="width:100%">
                                  @foreach($item['pinjam'] as $pj)  
                                  <div class="card">
                                   
                                        <button 
                                        @if($pj['status'] == 2) class="btn btn-danger text-left " 
                                        @elseif($pj['checkout'] != "") class="btn btn-info text-left " 
                                        @elseif($pj['checkin'] != "") class="btn btn-primary text-left " 
                                        @elseif($pj['status'] == 1) class="btn btn-success text-left " 
                                        @else class="btn btn-fik text-left " @endif

                                        type="button" data-toggle="collapse" data-target="#y{{$hitung.$item['id']}}" aria-expanded="true" aria-controls="y{{$hitung.$item['id']}}" style="width:100%;">
                                        <div class="row"><div class="col-11">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}} </div><div class="col-1 text-right"><i class="icofont-caret-down"></i></div></div>
                                           
                                        </button>
                                    

                                    <div id="y{{$hitung.$item['id']}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="width:100%; padding-left: 10px;" >
                                        <br>
                                        <div class="row">
                                            <div class="col-4"><h4>Checkin</h4></div>
                                            <div class="col-8"><h4>{{$pj['checkin']}}</h4></div>
                                            <div class="col-4"><h4>Checkout</h4></div>
                                            <div class="col-8"><h4>{{$pj['checkout']}}</h4></div>
                                            <div class="col-4"><h4>Catatan</h4></div>
                                            <div class="col-8"><h4>{{$pj['masalah']}}</h4></div>
                                            <div class="col-4"><h4>Dosen Penanggungjawab</h4></div>
                                            <div class="col-8"><h4>
                                                @if($pj['sdosen'] == 2) Tidak Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @elseif($pj['sdosen'] == 1) Sudah Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h4></div>
                                            <div class="col-4"><h4>Laboran / Kepala Laboratorium</h4></div>
                                            <div class="col-8"><h4>
                                                @if($pj['skalab'] == 2) Tidak Disetujui {{$pj['skalab']}} - {{PinjamController::dosen1($pj['skalab'])->nama}}
                                                @elseif($pj['skalab'] == 1) Sudah Disetujui {{$pj['statusKalab']}} - {{PinjamController::dosen1($pj['statusKalab'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h4></div>
                                            <div class="col-4"><h4>Lainnya</h4></div>
                                            <div class="col-8"><h4>{{$pj['keterangan']}}</h4></div>
                                        </div>
                                        <br>
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
                                <h5>{{$item['lokasi']}}<br>{{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                            </div>
                            <div class="row" style="margin-left: 10px;">
                                <a style="margin-bottom:5px; margin-right: 5px;" href="{{ url('lab/detail/'.$item['id']) }}" class="btn-sm btn-dark"> <i class="icofont-eye-alt"></i> Cek Laboratorium</a>
                            </div>
                            <div style="margin-top: auto; margin-bottom: auto;  text-align:left; min-width: 200px;  ">
                                <div style="padding:10px;">
                                    <h3>Jadwal Penggunaan</h3>
                                    <?php $hitung = 0; ?>
                                    <div class="accordion" id="accordionExample" style="width:100%">
                                    @foreach($item['pinjam'] as $pj)
                                    <div class="card">
                                   
                                        <button 
                                        @if($pj['status'] == 2) class="btn-sm btn-danger text-left " 
                                        @elseif($pj['checkout'] != "") class="btn-sm btn-info text-left " 
                                        @elseif($pj['checkin'] != "") class="btn-sm btn-primary text-left " 
                                        @elseif($pj['status'] == 1) class="btn-sm btn-success text-left " 
                                        @else class="btn-sm btn-fik text-left " @endif

                                        type="button" data-toggle="collapse" data-target="#y{{$hitung.$item['id']}}" aria-expanded="true" aria-controls="y{{$hitung.$item['id']}}" style="width:100%;">
                                        <div class="row"><div class="col-10">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}} </div><div class="col-1 text-right"><i class="icofont-caret-down"></i></div></div>
                                           
                                        </button>
                                    

                                    <div id="y{{$hitung.$item['id']}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="width:100%; padding-left: 10px;" >
                                        <br>
                                        <div class="row">
                                            <div class="col-4"><h5>Checkin</h5></div>
                                            <div class="col-8"><h5>{{$pj['checkin']}}</h5></div>
                                            <div class="col-4"><h5>Checkout</h5></div>
                                            <div class="col-8"><h5>{{$pj['checkout']}}</h5></div>
                                            <div class="col-4"><h5>Catatan</h5></div>
                                            <div class="col-8"><h5>{{$pj['masalah']}}</h5></div>
                                            <div class="col-4"><h5>Dosen Penanggungjawab</h5></div>
                                            <div class="col-8"><h5>
                                                @if($pj['sdosen'] == 2) Tidak Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @elseif($pj['sdosen'] == 1) Sudah Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h5></div>
                                            <div class="col-4"><h5>Laboran / Kepala Laboratorium</h5></div>
                                            <div class="col-8"><h5>
                                                @if($pj['skalab'] == 2) Tidak Disetujui {{$pj['skalab']}} - {{PinjamController::dosen1($pj['skalab'])->nama}}
                                                @elseif($pj['skalab'] == 1) Sudah Disetujui {{$pj['statusKalab']}} - {{PinjamController::dosen1($pj['statusKalab'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h5></div>
                                            <div class="col-4"><h5>Lainnya</h5></div>
                                            <div class="col-8"><h5>{{$pj['keterangan']}}</h5></div>
                                        </div>
                                        <br>
                                    </div>
                                  </div>
                                    <?php $hitung++; ?>
                                    @endforeach 
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div id="d{{$item['id']}}" class="col-lg-12 " style="margin-bottom:10px; min-width: 350px; max-height: 90%;">
                        <div class="card rounded" style=" min-width: 380px;">
                            <div style="margin-left: 1px;" class="row rounded-top" >
                                
                                <div class="col-3 md-4" style="position:relative;  overflow: hidden; min-height:200px; width:200px; ">
                                    <img style="position: absolute; margin-left: -50%; width:100%; min-height:200px;" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                                </div>
                                <div class="col-9 md-6">
                                <div style="text-align:left;margin-top: 20px;   ">     
                                    <h3>{{$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['lokasi']}}<br>{{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                                        </div>
                                    </div>
                                    <a style="margin-bottom:5px;" href="{{ url('lab/detail/'.$item['id']) }}" class="btn btn-dark"> <i class="icofont-eye-alt"></i> Cek Laboratorium</a>
                                </div>
                                </div>
                                <div class="col-12">
                                <div style="margin-top: auto; margin-bottom: auto;  text-align:left;  ">
                                    <div style="padding:15px;">
                                        <h3>Jadwal Penggunaan</h3>
                                        <div class="accordion" id="accordionExample" style="width:100%">
                                    <?php $hitung = 0; ?>
                                  @foreach($item['pinjam'] as $pj)  
                                  <div class="card">
                                   
                                        <button 
                                        @if($pj['status'] == 2) class="btn btn-danger text-left " 
                                        @elseif($pj['checkout'] != "") class="btn btn-info text-left " 
                                        @elseif($pj['checkin'] != "") class="btn btn-primary text-left " 
                                        @elseif($pj['status'] == 1) class="btn btn-success text-left " 
                                        @else class="btn btn-fik text-left " @endif

                                        type="button" data-toggle="collapse" data-target="#y{{$hitung.$item['id']}}" aria-expanded="true" aria-controls="y{{$hitung.$item['id']}}" style="width:100%;">
                                        <div class="row"><div class="col-11">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}} </div><div class="col-1 text-right"><i class="icofont-caret-down"></i></div></div>
                                           
                                        </button>
                                    

                                    <div id="y{{$hitung.$item['id']}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="width:100%; padding-left: 10px;" >
                                        <br>
                                        <div class="row">
                                            <div class="col-4"><h4>Checkin</h4></div>
                                            <div class="col-8"><h4>{{$pj['checkin']}}</h4></div>
                                            <div class="col-4"><h4>Checkout</h4></div>
                                            <div class="col-8"><h4>{{$pj['checkout']}}</h4></div>
                                            <div class="col-4"><h4>Catatan</h4></div>
                                            <div class="col-8"><h4>{{$pj['masalah']}}</h4></div>
                                            <div class="col-4"><h4>Dosen Penanggungjawab</h4></div>
                                            <div class="col-8"><h4>
                                                @if($pj['sdosen'] == 2) Tidak Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @elseif($pj['sdosen'] == 1) Sudah Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h4></div>
                                            <div class="col-4"><h4>Laboran / Kepala Laboratorium</h4></div>
                                            <div class="col-8"><h4>
                                                @if($pj['skalab'] == 2) Tidak Disetujui {{$pj['skalab']}} - {{PinjamController::dosen1($pj['skalab'])->nama}}
                                                @elseif($pj['skalab'] == 1) Sudah Disetujui {{$pj['statusKalab']}} - {{PinjamController::dosen1($pj['statusKalab'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h4></div>
                                            <div class="col-4"><h4>Lainnya</h4></div>
                                            <div class="col-8"><h4>{{$pj['keterangan']}}</h4></div>
                                        </div>
                                        <br>
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
                    </div>
                    @endif
                    @endif
                </div>
                    @endforeach
    
    </div>
    </div>  

    <br>
    <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Catatan Pemesanan</h2><span class="font-weight-light"></span>
        </div>
        <?php //dd($orderku); ?>
        <div class="row" style="margin: 5px 10px 5px 10px;">
           <div class="col-lg-12 text-left" style="margin: 10px 10px 10px 10px; min-height: 100px;">
                <h3><b>Catatan Pemesan</b></h4>
                <h4>{{$orderku[0]->notePeminjam}}</h4>
                <br>
                <h3><b>Catatan Dosen Penanggung Jawab</b></h3>
                <h4>{{$orderku[0]->noteDosen}}</h4>
                <br>
                <h3><b>Catatan Laboran / Kepala Laboratorium</b></h3>
                <h4>{{$orderku[0]->noteKalab}}</h4>
                <br>
                <h3><b>Catatan Pengambilan</b></h3>
                <h4>{{$orderku[0]->notePengambilan}}</h4>
                <br>
                <h3><b>Catatan Pengembalian</b></h3>
                <h4>{{$orderku[0]->notePengembalian}}</h4>
                <br>
            </div>
        </div>
    </div>
     <br>
                  


</div>
 </div></div>

@endsection