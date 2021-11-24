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
      <h1>Apakah Anda Yakin ?</h1>
      <h1>Perubahan Pengembalian Barang / Kehadiran Keluar</h1>
       <h3>Kepala Laboratorium  / Laboran</h3>
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
        <form method="post" action="{{url('balik/gantifinallab')}}">
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
                                            <div class="col-6"><h5>{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}}</h5></div>
                                             <div class="col-6">
                                                 @if($pj['balik'] == 1) 
                                                <h4 class="text-success">Pemesan Mengembalikan Barang</h4>
                                                <input  type="hidden" name="balikb[{{$pj['idp']}}]" value="1">
                                                @elseif($pj['balik'] == 2)
                                                <h4 class="text-primary">Terjadi Permasalahan / Kerusakan</h4>
                                                <input  type="hidden" name="balikb[{{$pj['idp']}}]" value="2"> 
                                                @elseif($pj['balik'] == 4)
                                                <h4 class="text-danger">Permasalahan Telah Diselesaikan</h4>
                                                <input  type="hidden" name="balikb[{{$pj['idp']}}]" value="4"> 
                                                @elseif($pj['balik'] == 5)
                                                <h4 class="text-danger">Batalkan Permasalahan</h4>
                                                <input  type="hidden" name="balikb[{{$pj['idp']}}]" value="5"> 
                                                @endif
                                            </div>
                                            
                                        </div>
                                         @if($pj['balik'] != 1) 
                                          <div style="margin-left: 1px;" class="row"><h5>Deskripsi Permasalahan</h5></div>
                                        <div style="margin-left: 1px;" class="row"><h6>{{$pj['masalah']}}</h6></div>
                                        <input type="hidden" name="masb[{{$pj['idp']}}]" value="{{$pj['masalah']}}">
                                        @endif
                                        <br>
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
                                            <div class="col-6">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}}</div>
                                            <div class="col-6">
                                                  @if($pj['balik'] == 1) 
                                                <h4 class="text-success">Pemesan Mengembalikan Barang</h4>
                                                <input  type="hidden" name="balikb[{{$pj['idp']}}]" value="1">
                                                @elseif($pj['balik'] == 2)
                                                <h4 class="text-danger">Terjadi Permasalahan / Kerusakan</h4>
                                                <input  type="hidden" name="balikb[{{$pj['idp']}}]" value="2"> 
                                                @elseif($pj['balik'] == 4)
                                                <h4 class="text-success">Permasalahan Telah Diselesaikan</h4>
                                                <input  type="hidden" name="balikb[{{$pj['idp']}}]" value="4"> 
                                                @elseif($pj['balik'] == 5)
                                                <h4 class="text-danger">Batalkan Permasalahan</h4>
                                                <input  type="hidden" name="balikb[{{$pj['idp']}}]" value="5"> 
                                                @endif
                                                @if($pj['balik'] != 1)
                                                 <h4>Deskripsi Permasalahan</h4>
                                                 <h5>{{$pj['masalah']}}</h5>
                                                 <input type="hidden" name="masb[{{$pj['idp']}}]" value="{{$pj['masalah']}}">
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
                                            <div class="col-6">
                                                <h5>{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}}</h5></div>
                                            <div class="col-6">
                                               @if($pj['balik'] == 1) 
                                                <h4 class="text-success">Pemesan Telah Meninggalkan Lab</h4>
                                                <input  type="hidden" name="balikl[{{$pj['idpl']}}]" value="1">
                                                @elseif($pj['balik'] == 2)
                                                <h4 class="text-danger">Terjadi Permasalahan / Kerusakan</h4>
                                                <input  type="hidden" name="balikl[{{$pj['idpl']}}]" value="2"> 
                                                @elseif($pj['balik'] == 4)
                                                <h4 class="text-success">Permasalahan Telah Diselesaikan</h4>
                                                <input  type="hidden" name="balikl[{{$pj['idpl']}}]" value="4"> 
                                                @elseif($pj['balik'] == 5)
                                                <h4 class="text-danger">Batalkan Permasalahan</h4>
                                                <input  type="hidden" name="balikl[{{$pj['idpl']}}]" value="5"> 
                                                @endif
                                            </div>
                                            
                                        </div>
                                        @if($pj['balik'] != 1) 
                                        <div style="margin-left: 1px;" class="row"><h5>Deskripsi Permasalahan</h5></div>
                                        <div style="margin-left: 1px;" class="row"><h6>{{$pj['masalah']}}</h6></div>
                                        <input type="hidden" name="masl[{{$pj['idpl']}}]" value="{{$pj['masalah']}}">
                                        @endif
                                        <br>
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
                                            <div class="col-6">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}}</div>
                                            <div class="col-6">
                                               @if($pj['balik'] == 1) 
                                                <h4 class="text-success">Pemesan Telah Meninggalkan Lab</h4>
                                                <input  type="hidden" name="balikl[{{$pj['idpl']}}]" value="1">
                                                @elseif($pj['balik'] == 2)
                                                <h4 class="text-danger">Terjadi Permasalahan / Kerusakan</h4>
                                                <input  type="hidden" name="balikl[{{$pj['idpl']}}]" value="2"> 
                                                @elseif($pj['balik'] == 4)
                                                <h4 class="text-success">Permasalahan Telah Diselesaikan</h4>
                                                <input  type="hidden" name="balikl[{{$pj['idpl']}}]" value="4"> 
                                                @elseif($pj['balik'] == 5)
                                                <h4 class="text-danger">Batalkan Permasalahan</h4>
                                                <input  type="hidden" name="balikl[{{$pj['idpl']}}]" value="5"> 
                                                
                                                @endif
                                                @if($pj['balik'] != 1)
                                                 <h4>Deskripsi Permasalahan</h4>
                                                 <h5>{{$pj['masalah']}}</h5>
                                                 <input type="hidden" name="masl[{{$pj['idpl']}}]" value="{{$pj['masalah']}}">
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
         <div class="row" style="margin: 0px 10px 0px 10px;">
            <div class="col-lg-12 " style="margin-bottom:10px; ">
                <div class="card rounded">
                    <div style="margin-left: 10px;" class=" rounded-top text-left" >  
                        <h3>Catatan Pengembalian / Kehadiran Keluar</h3>         
                        <h4>{{$pesan}}</h4>
                    </div>
                </div>
            </div>        
        </div>            
        <input type="hidden" name="idambilbalik" value="{{$ambilin[0]->idambilbalik}}"> 
        <input type="hidden" name="pesan" value="{{$pesan}}"> 
     @if(isMobile())                
    <button style="width: 90%; margin: 0px auto 10px auto;" class="btn btn-danger text-wrap">Ya, Simpan Pengembalian / Kehadiran Keluar</button>
    @else
     <button style="width: 98%; margin: 0px auto 10px auto;" class="btn btn-danger">Ya, Simpan Pengembalian / Kehadiran Keluar</button>
    @endif
    </form>   
   <form>
    @if(isMobile())                
    
    <a href="{{url('balik/balikdetaildosen/'.$ambilin[0]->idambilbalik)}}" style="width: 90%; margin: 0px 10px 10px 10px;" class="btn btn-dark text-wrap">Tidak, Kembali Ke Halaman Sebelumnya</a>
    @else
    
    <a href="{{url('balik/balikdetaildosen/'.$ambilin[0]->idambilbalik)}}" style="width: 97%; margin: 0px 10px 10px 10px;" class="btn btn-dark">Tidak, Kembali Ke Halaman Sebelumnya</a>
    @endif
    </form>
    </div>
    </div>  
      </div>
</div>
</div>

@endsection