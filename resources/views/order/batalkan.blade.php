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
      <h1>Membatalkan Pesanan</h1>
      <h1>Nomor Pesanan : {{$orderku[0]->idorder}}</h1>
      <h3>Waktu Pesanan Dibuat : {{$orderku['0']->tanggal}}</h3>
      <a style="margin-bottom: 5px; width: 100%;" href="{{url('order/detail/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-dark">Kembali</a>
      <br>
      @if(session('status'))
          @if(session('status') == 3)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Item Berhasil Dibatalkan</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
          @elseif(session('status') == 1)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="icofont-error"></i></span>
          <span class="alert-inner--text">Item Gagal Dibatalkan, Terjadi Perubahan Status</a></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          </div>
          @elseif(session('status') == 2)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="icofont-error"></i></span>
          <span class="alert-inner--text">Tidak Ada Item Yang Dipilih</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
          @endif
        @endif  
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
                  <tr><td>Pemesan </td><td><b>{{ $pemesan[0]->nrpnpk }} - {{ $pemesan[0]->nama }}</b></td></tr>
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
        <form method="post" action="{{url('order/pbatalkan')}}">
           @foreach($keranjang as $item)
                <div class="row" style="margin: 0px 10px 0px 10px;">
                  <?php $gambar = $item['gambar'];?>
                  @if($item['tipe'] == "barang")
                  @if(isMobile())
                  <div id="d{{$item['id']}}" class="col-lg-12" style=" width: 100%; max-height: 90%;">
                        <div class="card rounded" >
                            <div class="row rounded-top" style="width: 100%; margin-left: 1px;">
                                <div class="col-12 md-12">
                                <div style="text-align:left;margin-top: 10px;   ">     
                                    <div class="row">
                                        <div style="width: 100%;">
                                    <h3 class="card-title wrap">{{$item['merk']." ".$item['nama']}}</h3>
                                            <h5 class="text-wrap">{{$item['barang']}} | {{$item['kat']}} |  {{$item['lab']}} | 
                                            {{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="col-12">
                                <div class="row" style="margin-top: auto; margin-bottom: auto;  text-align:left;  ">
                                    <div style="padding:5px;">
                                        <h4>Jadwal Penggunaan</h4>
                                        <?php $hitung = 0; ?>
                                        @foreach($item['pinjam'] as $pj)  
                                        <div class="row">
                                            <div class="col-12"><h5>{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}}</h5></div>
                                            <div class="col-12">
                                                @if($pj['sdosen'] == 2 || $pj['status'] == 2 || $pj['checkout'] != "" || $pj['checkin'] != "" || $pj['skalab'] == 2 || $pj['checkout1'] != "" || $pj['checkin1'] != "")
                                                <h4 class="text-danger">Item Tidak Dapat Dibatalkan</h4>
                                                @else
                                                <div class="custom-control custom-switch" style="margin-left : 10px;">
                                                  <input  type="checkbox" class="custom-control-input" name="cancelb[{{$pj['idp']}}]" id="b{{$pj['idp']}}" value="{{$pj['idp']}}"  >
                                                  <label  class="custom-control-label" for="b{{$pj['idp']}}">Batalkan Pesanan</label>
                                                </div>
                                                @endif
                                            </div>
                                            <br><br>
                                        </div>
                                        @endforeach
                                    </div>
                             
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
                                                @if($pj['sdosen'] == 2 || $pj['status'] == 2 || $pj['checkout'] != "" || $pj['checkin'] != "" || $pj['skalab'] == 2 || $pj['checkout1'] != "" || $pj['checkin1'] != "")
                                                <h4 class="text-danger">Item Tidak Dapat Dibatalkan</h4>
                                                @else
                                                <div class="custom-control custom-switch">
                                                  <input  type="checkbox" class="custom-control-input" name="cancelb[{{$pj['idp']}}]" id="b{{$pj['idp']}}" value="{{$pj['idp']}}"  >
                                                  <label  class="custom-control-label" for="b{{$pj['idp']}}">Batalkan Pesanan</label>
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
                    <div id="d{{$item['id']}}" class="col-lg-12" style=" width: 100%; max-height: 90%;">
                        <div class="card rounded" >
                            <div class="row rounded-top" style="width: 100%; margin-left: 1px;">
                                <div class="col-12 md-12">
                                <div style="text-align:left;margin-top: 10px;   ">     
                                    <div class="row">
                                        <div style="width: 100%;">
                                    <h3 class="card-title wrap">{{$item['nama']}}</h3>
                                            <h5 class="text-wrap">{{$item['lokasi']}} | {{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="col-12">
                                <div class="row" style="margin-top: auto; margin-bottom: auto;  text-align:left;  ">
                                    <div style="padding:5px;">
                                        <h4>Jadwal Penggunaan</h4>
                                        <?php $hitung = 0; ?>
                                        @foreach($item['pinjam'] as $pj)  
                                        <div class="row">
                                            <div class="col-12"><h5>{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}}</h5></div>
                                            <div class="col-12">
                                                 @if($pj['sdosen'] == 2 || $pj['status'] == 2 || $pj['checkout'] != "" || $pj['checkin'] != "" || $pj['skalab'] == 2 || $pj['checkout1'] != "" || $pj['checkin1'] != "")
                                                <h4 class="text-danger">Item Tidak Dapat Dibatalkan</h4>
                                                @else
                                                <div class="custom-control custom-switch" style="margin-left : 10px;">
                                                  <input  type="checkbox" class="custom-control-input" name="cancell[{{$pj['idpl']}}]" id="l{{$pj['idpl']}}" value="{{$pj['idpl']}}"  >
                                                  <label  class="custom-control-label" for="l{{$pj['idpl']}}">Batalkan Pesanan</label>
                                                </div>
                                                @endif
                                            </div>
                                            <br><br>
                                        </div>
                                        @endforeach
                                    </div>
                             
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
                                        <?php $hitung = 0; ?>
                                        @foreach($item['pinjam'] as $pj)  
                                        <div class="row">
                                            <div class="col-4">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}}</div>
                                            <div class="col-8">
                                                @if($pj['sdosen'] == 2 || $pj['status'] == 2 || $pj['checkout'] != "" || $pj['checkin'] != "" || $pj['skalab'] == 2 || $pj['checkout1'] != "" || $pj['checkin1'] != "")
                                                <h4 class="text-danger">Item Tidak Dapat Dibatalkan</h4>
                                                @else
                                                <div class="custom-control custom-switch">
                                                  <input type="checkbox" class="custom-control-input" name="cancell[{{$pj['idpl']}}]" id="l{{$pj['idpl']}}" value="{{$pj['idpl']}}"  >
                                                  <label class="custom-control-label" for="l{{$pj['idpl']}}">Batalkan Pesanan</label>
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
                    @endif
                </div>
                    @endforeach
                    @csrf
        <input type="hidden" name="orderid" value="{{$orderku[0]->idorder}}">   
    @if(isMobile())                
        <button type="submit" name="cancelselected" style="width: 90%; margin: 0px auto 10px auto;" class="btn btn-fik">Batalkan Pesanan Terpilih</button>
    @else
     <button type="submit" name="cancelselected" style="width: 98%; margin: 0px auto 10px auto;" class="btn btn-fik">Batalkan Pesanan Terpilih</button>
    @endif  

    </form>  
   
     

    @if(isMobile())                
        <form  method="post" action="{{url('order/pbatalkan')}}">
            @csrf
            <input type="hidden" name="cancelall" value="1">
            <input type="hidden" name="orderid" value="{{$orderku[0]->idorder}}">
            <button type="submit" name="cancelall1" style="width: 90%; margin: 0px auto 10px auto;" class="btn btn-danger">Batalkan Seluruh Pesanan*</button>
           
            <h5 style="width: 90%; margin-left: auto; margin-right: auto;">*Hanya Membatalkan Seluruh Pesanan <b>Yang Dapat Dibatalkan</b></h5>
         </form>    
    @else
    <form method="post" action="{{url('order/pbatalkan')}}">
        @csrf
        <input type="hidden" name="orderid" value="{{$orderku[0]->idorder}}">
        <input type="hidden" name="cancelall" value="1">
        <button type="submit" name="cancelall1" style="width: 98%; margin: 0px auto 10px auto;" class="btn btn-danger">Batalkan Seluruh Pesanan*</button>
        <h5 style="width: 90%; margin-left: auto; margin-right: auto;">*Hanya Membatalkan Seluruh Pesanan <b>Yang Dapat Dibatalkan</b></h5>
    </form>
    @endif
 
    </div>
    </div>  
    </div>
</div></div>

@endsection