
<?php use App\Http\Controllers\PinjamController; ?>
<?php use App\Http\Controllers\PinjamLabController; ?>
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
      <h1> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Keranjang</h1>
      <br>
      @if(session('status'))
  @if(session('status') == 3)
  <div class="alert alert-success alert-dismissible fade show" role="alert">
  <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
  <span class="alert-inner--text">Barang Berhasil Ditambahkan Ke Keranjang</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span></button>
</div>
  @elseif(session('status') == 1)
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <span class="alert-inner--icon"><i class="icofont-error"></i></span>
  <span class="alert-inner--text">Keranjang Telah Diperbarui, Silahkan Checkout Kembali</a></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span></button>
  </div>
  @elseif(session('status') == 2)
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <span class="alert-inner--icon"><i class="icofont-error"></i></span>
  <span class="alert-inner--text">Barang Gagal Ditambahkan Karena Bertabrakan Dengan Keranjang</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span></button>
</div>
  @endif
@endif  

      <div class="keranjang11" id="keranjang11">
      @if(session('cart'))
      <button style="width: 100%; margin-top: 10px;" id="clean11" class=" btn btn-dark" >Bersihkan Keranjang</button>
      @else
      <button style="width: 100%; margin-top: 10px;"  class=" btn btn-dark" >Keranjang Anda Kosong</button>
      @endif
      </div>
    </div>
  </div>
</div>
<br>
<div style="margin-left: auto; margin-right: auto;">
    @if(session('cart'))
    <div class="row text-center" id="keranjang13" style="margin-left: auto; margin-right: auto;" >
         <div class="card card-profile shadow " style="width: 100%;">
            <div class="card-header text-left">
                <h2>Item Yang Dipesan</h2><span class="font-weight-light"></span>
            </div>  
              
           @foreach(session('cart') as $item)
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
                                <h5>{{$item['barang']}}<br>{{$item['kat']}}<br><br>{{$item['lab']}}<br>{{PinjamController::fakultas1($item['fakultas'])->namafakultas}}</h5>
                            </div>
                            <div class="row" style="margin-left: 10px;">
                                <a style="margin-bottom:5px; margin-right: 5px;" href="{{ url('barang/detail2/'.$item['id']) }}" class="btn-sm btn-dark"> <i class="icofont-eye-alt"></i> Cek Barang</a>
                                <button onclick="delete12('d{{$item['id']}}');" style="margin-bottom:5px;" class="btn-sm btn-danger"><i class="icofont-ui-delete"></i> Hapus Barang</button>
                            </div>
                            <div style="margin-top: auto; margin-bottom: auto;  text-align:left; min-width: 200px;  ">
                                <div style="padding:10px;">
                                    <h3>Jadwal Peminjaman</h3>
                                    <?php $hitung = 0; ?>
                                    @foreach($item['pinjam'] as $pj)
                                    <div id="f{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}" class="btn-group" role="group" style="margin-bottom:5px;" id="e{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}">
                                        <button class="btn-sm btn-fik"> 
                                            {{$pj['tgl']}} | {{$pj['mulai']." - ".$pj['selesai']}} </button> 
                                            <button onclick="delete11('e{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}','d{{$item['id']}}');" class="btn-sm btn-danger" style=" margin-left:5px;"><i class="icofont-ui-delete"></i> Hapus
                                        </button>
                                        
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
                                    <h3 class="card-title wrap">{{$item['merk']." ".$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['barang']." | ".$item['kat']}}<br><br>{{$item['lab']}}<br>{{PinjamController::fakultas1($item['fakultas'])->namafakultas}}</h5>
                                        </div>
                                    </div>
                                    <a style="margin-bottom:5px;" href="{{ url('barang/detail2/'.$item['id']) }}" class="btn btn-dark"> <i class="icofont-eye-alt"></i> Cek Barang</a>
                                    <button onclick="delete12('d{{$item['id']}}');" style="margin-bottom:5px;" class="btn btn-danger"><i class="icofont-ui-delete"></i> Hapus Barang</button>
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
                                                    <button onclick="delete11('e{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}','d{{$item['id']}}');" id="e{{$hitung.$item['id']}}" class="btn btn-danger" style=" margin-left:5px;"><i class="icofont-ui-delete"></i> Hapus</button>
                                                  
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
                                <h5>{{$item['lokasi']}}<br>{{PinjamController::fakultas1($item['fakultas'])->namafakultas}}</h5>
                            </div>
                            <div class="row" style="margin-left: 10px;">
                                <a style="margin-bottom:5px; margin-right: 5px;" href="{{ url('lab/detail/'.$item['id']) }}" class="btn-sm btn-dark"> <i class="icofont-eye-alt"></i> Cek Laboratorium</a>
                                <button onclick="delete12('d{{$item['id']}}');" style="margin-bottom:5px;" class="btn-sm btn-danger"><i class="icofont-ui-delete"></i> Hapus Laboratorium</button>
                            </div>
                            <div style="margin-top: auto; margin-bottom: auto;  text-align:left; min-width: 200px;  ">
                                <div style="padding:10px;">
                                    <h3>Jadwal Penggunaan</h3>
                                    <?php $hitung = 0; ?>
                                    @foreach($item['pinjam'] as $pj)
                                    <div id="f{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}" class="btn-group" role="group" style="margin-bottom:5px;" id="e{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}">
                                        <button class="btn-sm btn-fik"> 
                                            {{$pj['tgl']}} | {{$pj['mulai']." - ".$pj['selesai']}} </button> 
                                            <button onclick="delete11('e{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}','d{{$item['id']}}');" class="btn-sm btn-danger" style=" margin-left:5px;"><i class="icofont-ui-delete"></i> Hapus
                                        </button>
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
                                    <h3 class="card-title wrap">{{$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['lokasi']}}<br>{{PinjamController::fakultas1($item['fakultas'])->namafakultas}}</h5>
                                        </div>
                                    </div>
                                    <a style="margin-bottom:5px;" href="{{ url('lab/detail/'.$item['id']) }}" class="btn btn-dark"> <i class="icofont-eye-alt"></i> Cek Laboratorium</a>
                                    <button onclick="delete12('d{{$item['id']}}');" style="margin-bottom:5px;" class="btn btn-danger"><i class="icofont-ui-delete"></i> Hapus Laboratorium</button>
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
                                                    <button onclick="delete11('e{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}','d{{$item['id']}}');" id="e{{$hitung.$item['id']}}" class="btn btn-danger" style=" margin-left:5px;"><i class="icofont-ui-delete"></i> Hapus</button>
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
                </div>
                    @endforeach
        </div>
        @endif
    </div>
</div>
<br>
<div id="keranjang12">
      <form id="iniform" action="{{url('keranjang/checkout')}}" method="post"> @csrf
    @if(session('cart'))
    <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header">
            <h2>Dosen Penanggungjawab<span class="font-weight-light"></span></h2>
        </div>
   
        <div class="row" style="margin: 20px 20px 5px 20px;">
            <div class="col-md-12">
                <h4>Pilih Dosen</h4>
                <select class="select2 form-control-lg dosen1" style="width:100%;" name="dosen" id="dosen1" required="">
                  <option value="" disabled selected>Pilih Dosen Penanggungjawab</option>
                  @foreach($dosen as $d)
                  <option value="{{$d->nrpnpk}}">{{$d->nama." - ".KeranjangController::jurusan($d->jurusan)}}</option>
                  @endforeach
              </select>
          </div>
      </div>
      <div class="row card" id="datadosen" style="margin: 5px 20px 5px 20px;"></div>
  </div><br>
   <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header">
            <h2>Catatan Pemesanan<span class="font-weight-light"></span></h2>
        </div>
   
        <div class="row" style="margin: 20px 20px 5px 20px;">
            <div class="col-md-12">
              
                    <textarea class="form-control" name="pesan" rows="3"></textarea>
                    <br>
                    <input type="hidden" name="random" value="{{$random}}">
                    
               
   
          </div>
      </div>
  </div>
  <input type="submit" name="ok" style="width: 100%; margin-top: 10px;" id="checkout11" class="btn btn-fik" value="Checkout" >
                  <?php if (1==2){ ?>
                  <div class="row"><h2 class="text-left">Kode Dispensasi</h2></div>
                  <input  class="form-control" type="text" name="kode">
                  <br>
                </form>  <?php } ?>
   @endif
</div>           
                  </div>
                  
              </div> 
            </div>
                
              </div>

<script>

   function delete11(id, ids)
   {
    $.ajax({
        type: "GET",
        url: "{{url('keranjang/hapusPinjam')}}",
        data: {id:id,kr:'kr'},
        success: function(data) {
            if(data == 1){ $('#'+id).remove(); }
            else if (data == 0) { $('#'+ids).remove(); cekkeranjang11(); }
            else if (data == 2) { 
                $('#keranjang11').empty();
                $('#keranjang13').empty();
                $('#keranjang12').empty();
                $('#keranjang11').append('<button style="width: 100%; margin-top: 10px;"  class=" btn btn-dark" >Keranjang Anda Kosong</button>');
            }
            else {}
        }
    });   
   }
 
$(document).ready(function(){

   cekkeranjang11()
   $('.select2').select2();
   $('#dosen1').on("change", function (e) {
    $('#datadosen').empty();
    $('#datadosen').append('<div style="margin:5px;" class ="text-center"><div class="spinner-border text-fik" role="status"></div><br><br><h3>Loading....</h3></div> ');
    $.ajax({
        type: "GET",
        url: "{{url('keranjang/dosen')}}",
        data: {
            'dosen': this.value
        },
        success: function(data) {
          
          $('#datadosen').empty();
          $('#datadosen').append(data);
        }
    });

   });

});

   function cekkeranjang11()
   {
    <?php $hitung2 = 0; $hitung3 = 0; $hitung4 =0;?>
    @if(session('cart')!=null)
     @foreach(session('cart') as $item)
        @foreach($item['pinjam'] as $pj)
        <?php 
            if($item['tipe'] == "barang")
            {
                if(PinjamController::cekada($item['id'],$pj['tgl'],$pj['mulai'],$pj['selesai'])==1 ){ ?>
                @if(isMobile())
                    $('#f{{str_pad($hitung2,4,'0',STR_PAD_LEFT).$item['id']}}').append(
                        '<button class="btn-sm text-danger"style=" margin-left:5px;" >'+ 
                        '<i class="icofont-warning"></i> Item Tidak Tersedia</button>');
                @else
                    $('#f{{str_pad($hitung2,4,'0',STR_PAD_LEFT).$item['id']}}').append(
                        '<button class="btn text-danger"style=" margin-left:5px;" >'+ 
                        '<i class="icofont-warning"></i> Item Tidak Tersedia</button>');
                @endif                    
                <?php $hitung4++;  }
                $hitung2++;    
            }
            else if($item['tipe'] == "lab")
            {
                if(PinjamLabController::cekada($item['id'],$pj['tgl'],$pj['mulai'],$pj['selesai'])==1  ){ ?>
                @if(isMobile())
                    $('#f{{str_pad($hitung3,4,'0',STR_PAD_LEFT).$item['id']}}').append(
                        '<button class="btn-sm text-danger"style=" margin-left:5px;" >'+ 
                        '<i class="icofont-warning"></i> Item Tidak Tersedia</button>');
                @else
                    $('#f{{str_pad($hitung3,4,'0',STR_PAD_LEFT).$item['id']}}').append(
                        '<button class="btn text-danger"style=" margin-left:5px;" >'+ 
                        '<i class="icofont-warning"></i> Item Tidak Tersedia</button>');
                @endif   
                <?php $hitung4++; } 
                $hitung3++; 
            }
        ?>
        @endforeach
     @endforeach
     @endif
     var hasil = {{$hitung4}};
     if( hasil != 0) { $('#checkout11').prop('disabled', true); }   
     else { $('#checkout').prop('disabled', false); }   
   }
   function delete12(id)
   {
     $.ajax({
        type: "GET",
        url: "{{url('keranjang/hapusBarang')}}",
        data: {id:id,kr:'kr'},
        success: function(data) {
            if(data == 1){ $('#'+id).remove(); cekkeranjang11(); }
            else if (data == 2) { 
               $('#keranjang11').empty();
                $('#keranjang13').empty();
                $('#keranjang12').empty();
                $('#keranjang11').append('<button style="width: 100%; margin-top: 10px;"  class=" btn btn-dark" >Keranjang Anda Kosong</button>');
            }
            else {}; 
        }
    }); 
   }

$('#clean11').on('click', function() {
    $('#keranjang11').empty();
    $('#keranjang11').append('<div class="spinner-border text-fik" role="status"></div><br><br><h3>Loading....</h3> ');
    $.ajax({
        type: "GET",
        url: "{{url('keranjang/clean')}}",
        data: {kr:'kr'},
        success: function(data) {
            $('#keranjang11').empty();
            $('#keranjang13').empty();
            $('#keranjang12').empty();
            $('#keranjang11').append('<button style="width: 100%; margin-top: 10px;"  class=" btn btn-dark" >Keranjang Anda Kosong</button>');
        }
    });   
});

</script>
@endsection