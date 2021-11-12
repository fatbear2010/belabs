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
      <h1>Apakah Anda Yakin Untuk Membatalkan ?</h1>
      <h3>Nomor Pesanan : {{$orderku[0]->idorder}}</h3>
      <br>
      <br>
    </div>
  </div>
</div>
<br>
<div style="margin-left: auto; margin-right: auto;">

   <div class="row text-center" id="keranjang13" style="margin-left: auto; margin-right: auto;">
     <div class="card card-profile shadow " style="width: 100%;">
        <form method="post" action="{{url('order/pbatalkan2')}}">
            @csrf
           @foreach($keranjang as $item)
                <div class="row" style="margin: 0px 10px 0px 10px;">
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
                                              <input  type="hidden" name="cancelb[{{$pj['idp']}}]" value="{{$pj['idp']}}">
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
                                            <div class="col-12">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}}</div>
                                            <input  type="hidden" name="cancelb[{{$pj['idp']}}]" value="{{$pj['idp']}}">
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
                                            <input  type="hidden" name="cancell[{{$pj['idpl']}}]" value="{{$pj['idpl']}}">
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
                                            <div class="col-12">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}}</div>
                                            <input  type="hidden" name="cancell[{{$pj['idpl']}}]" value="{{$pj['idpl']}}">
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
        <input type="hidden" name="orderid" value="{{$orderku[0]->idorder}}"> 
     @if(isMobile())                
    <button style="width: 90%; margin: 0px auto 10px auto;" class="btn btn-danger">Ya Batalkan Pesanan</button>
    @else
     <button style="width: 98%; margin: 0px auto 10px auto;" class="btn btn-danger">Ya Batalkan Pesanan</button>
    @endif
    </form>   
   <form>
    @if(isMobile())                
    
    <a href="{{url('order/batalkan/'.$orderku[0]->idorder)}}" style="width: 97%; margin: 0px 10px 10px 10px;" class="btn btn-dark text-wrap">Tidak, Batalkan Pesanan Nanti</a>
    @else
    
    <a href="{{url('order/batalkan/'.$orderku[0]->idorder)}}" style="width: 97%; margin: 0px 10px 10px 10px;" class="btn btn-dark text-wrap">Tidak, Batalkan Pesanan Nanti</a>
    @endif
    </form>
    </div>
    </div>  
      </div>
</div>
</div>

@endsection