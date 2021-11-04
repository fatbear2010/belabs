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
      <br>
    </div>
  </div>
</div>
<br>
<div style="margin-left: auto; margin-right: auto;">
    <div class="card card-profile shadow " style="width: 100%;">
        <div class="row" style="margin: 5px 10px 5px 10px;">
            <div class="col-lg-12 text-left table-responsive">
                <table class="table wrap">
                  <tr><td>Pemesan </td><td><b>{{ auth()->user()->nrpnpk }} - {{ auth()->user()->nama }}</b></td></tr>
                  <tr><td>Penanggung Jawab</td><td><b>{{ $dosenpj[0]->nrpnpk }} - {{ $dosenpj[0]->nama }}</b></td></tr>
                </table>
            </div>
        </div>
    </div>
    <br>

   <div class="row text-center" id="keranjang13" style="margin-left: auto; margin-right: auto;">
     <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Item Yang Dipesan</h2>
        </div>
        <form>
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
                                <h5>{{$item['barang']}}<br>{{$item['kat']}}<br><br>{{$item['lab']}}<br>{{$item['fakultas']}}</h5>
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
                                                @elseif($pj['skalab'] == 1) Sudah Disetujui {{$pj['skalab']}} - {{PinjamController::dosen1($pj['skalab'])->nama}}
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
                                <div class="col-12 md-12">
                                <div style="text-align:left;margin-top: 20px;   ">     
                                    <h3 class="card-title wrap">{{$item['merk']." ".$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['barang']." | ".$item['kat']}}<br>{{$item['lab']}} | 
                                            {{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="col-12">
                                <div style="margin-top: auto; margin-bottom: auto;  text-align:left;  ">
                                    <div style="padding:15px;">
                                        <h3>Jadwal Penggunaan</h3>
                                        <?php $hitung = 0; ?>
                                        @foreach($item['pinjam'] as $pj)  
                                        <div class="row">
                                            <div class="col-4">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}}</div>
                                            <div class="col-8">
                                                @if(2==2)
                                                <h4 class="text-danger">Item Tidak Dapat Dibatalkan</h4>
                                                @else
                                                <div class="custom-control custom-switch">
                                                  <input type="checkbox" class="custom-control-input" name="cancel[{{$pj['idp']}}]" id="{{$pj['idp']}}" value="1"  >
                                                  <label class="custom-control-label" for="{{$pj['idp']}}">Batalkan Pesanan</label>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
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
                                                @elseif($pj['skalab'] == 1) Sudah Disetujui {{$pj['skalab']}} - {{PinjamController::dosen1($pj['skalab'])->nama}}
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
                                
                                <div class="col-12 md-12">
                                <div style="text-align:left;margin-top: 20px;   ">     
                                    <h3>{{$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['lokasi']}}<br>{{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                                        </div>
                                    </div>
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
                                                @elseif($pj['skalab'] == 1) Sudah Disetujui {{$pj['skalab']}} - {{PinjamController::dosen1($pj['skalab'])->nama}}
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
    <button style="width: 98%; margin: 0px auto 10px auto;" class="btn btn-fik">Batalkan Pesanan Terpilih</button>
</form>
    <button style="width: 98%; margin: 0px auto 10px auto;" class="btn btn-danger">Batalkan Seluruh Pesanan*</button>
    <h5>*Hanya Membatalkan Seluruh Pesanan <b>Yang Dapat Dibatalkan</b></h5>
    </div>
    </div>  

    <br>
    
</div>
 </div></div>

@endsection