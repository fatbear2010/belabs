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
   
      <h1>Detail Pengembalian Item / Kehadiran Keluar</h1>
      <h1>Nomor Pesanan : {{$orderku[0]->idorder}}</h1>
       @if(!isset($apa))
      <h3>Waktu Pesanan Dibuat : {{$orderku['0']->tanggal}}</h3>
      <h1>Kode Pengambilan: {{$ambilin[0]->abcode}}</h1>
    @endif  
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
          <span class="alert-inner--text">Data Gagal Disimpan, Terjadi Perubahan Status</a></span>
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
                  <tr><td>Kalab / Laboran Yang Bertugas</td><td><b>{{KeranjangController::cariorang($ambilin[0]->PIC)}}</b></td></tr>
                  <tr><td>Waktu Pemrosesan</td><td><b>{{$ambilin[0]->time}}</b></td></tr>
                  <tr><td>Waktu Pengembalian / Keluar</td><td><b>@if($ambilin[0]->time2 == "") Item Belum Diambil / Belum Hadir @else {{$ambilin[0]->time2}}@endif</b></td></tr>
                  <tr><td>Catatan Pengembalian</td><td><b>{{$ambilin[0]->note}}</b></td></tr>
                </table>
            </div>
        </div>
    </div>

   <div class="row text-center" id="keranjang13" style="margin-left: auto; margin-right: auto;">
     <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Item Yang Dikembalikan / Kehadiran Keluar</h2>
        </div>
        <form method="post" action="{{url('ambil/proses')}}">
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
                                                @if($pj['checkin1'] != "")
                                                <h4 class="text-danger">Item Telah Diambil </h4>
                                                @elseif (!isset($apa))
                                                <div class="form-group" style="margin-left : 10px;">
                                                  <select class="form-control" name="setujub[{{$pj['idp']}}]">
                                                        <option value="1">Item Sudah Diambil</option>
                                                        <option value="2">Item Tidak Diambil</option>
                                                        <option value="3">Batalkan Pengambilan Item</option>
                                                        <option selected value="0">Tidak Ada Tindakan</option>
                                                  </select>  
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
                                                @if($pj['checkin1'] != "")
                                                <h4 class="text-danger">Item Telah Diambil</h4>
                                                @elseif (!isset($apa))
                                                <div class="form-group" style="margin-left : 10px;">
                                                  <select class="form-control" name="setujub[{{$pj['idp']}}]">
                                                        <option value="1">Item Sudah Diambil</option>
                                                        <option value="2">Item Tidak Diambil</option>
                                                        <option value="3">Batalkan Pengambilan Item</option>
                                                        <option selected value="0">Tidak Ada Tindakan</option>
                                                  </select>  
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
                                                @if($pj['checkin1'] != "")
                                                <h4 class="text-danger">Pemesan Telah Hadir</h4>
                                                @elseif (!isset($apa))
                                               <div class="form-group" style="margin-left : 10px;">
                                                  <select class="form-control" name="setujul[{{$pj['idpl']}}]">
                                                         <option value="1">Pemesan Sudah Hadir</option>
                                                        <option value="2">Pemesan Tidak Hadir</option>
                                                        <option value="3">Batalkan Kehadiran</option>
                                                        <option selected value="0">Tidak Ada Tindakan</option>
                                                  </select>  
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
                                               @if($pj['checkin1'] != "")
                                                <h4 class="text-danger">Pemesan Telah Hadir</h4>
                                                @elseif (!isset($apa))
                                                 <div class="form-group" style="margin-left : 10px;">
                                                  <select class="form-control" name="setujul[{{$pj['idpl']}}]">
                                                        <option value="1">Pemesan Sudah Hadir</option>
                                                        <option value="2">Pemesan Tidak Hadir</option>
                                                        <option value="3">Batalkan Kehadiran</option>
                                                        <option selected value="0">Tidak Ada Tindakan</option>
                                                  </select>  
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
           @if(!isset($apa))          
         <div class="row" style="margin: 0px 10px 0px 10px;">
            <div class="col-lg-12 " style="margin-bottom:10px; ">
                <div class="card rounded">
                    <div style="margin-left: 1px;" class="row rounded-top" >  
                        <h3>Catatan Pengembalian  / Kehadiran Keluar</h3>         
                        <textarea id="txta" style="max-width:100%;" class="form-control" name="pesan" rows="3">{{$ambilin[0]->note}}</textarea>
                    </div>
                </div>
            </div>        
        </div>
        <input type="hidden" name="idambilbalik" value="{{$ambilin[0]->idambilbalik}}">   
    @if(isMobile())                
        <button type="submit" name="agreeselected" style="width: 90%; margin: 0px auto 10px auto;" class="btn btn-fik">Simpan Pengambilan / Kehadiran Masuk</button>
    @else
     <button type="submit" name="agreeselected" style="width: 98%; margin: 0px auto 10px auto;" class="btn btn-fik">Simpan Pengambilan / Kehadiran Masuk</button>
    @endif 
@else
   <div class="row" style="margin: 0px 10px 0px 10px;">
            <div class="col-lg-12 " style="margin-bottom:10px; ">
                <div class="card rounded">
                    <div style="margin-left: 1px;" class=" rounded-top text-left" >  
                        <h3>Catatan Pengembalian / Kehadiran Keluar</h3>        
                        <h5>{{$ambilin[0]->note}}</h5>
                    </div>
                </div>
            </div>        
        </div>  
@endif

    </form>  
    </div>
    </div>  
    </div>
</div></div>
<script type="text/javascript">
$('#txta').change(function() {
     $('#txtc').val($("#txta").val());
});    
$(document).ready(function () {
});
</script>
@endsection