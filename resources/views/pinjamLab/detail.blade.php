<?php use App\Http\Controllers\PinjamController; ?>
<?php
  function isMobile() {
      return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }
  ?>
@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="row">

<div class="container-fluid mt--7">
  <div class="row">
      <div class="col-xl-12 mb-5 mb-xl-0">
<!--div -->
@if(session('status'))
  @if(session('status') == 3)
  <div class="alert alert-success alert-dismissible fade show" role="alert">
  <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
  <span class="alert-inner--text">Penggunaan Laboratorium Berhasil Ditambahkan Ke Keranjang</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span></button>
</div>
  @elseif(session('status') == 1)
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <span class="alert-inner--icon"><i class="icofont-error"></i></span>
  <span class="alert-inner--text">Penggunaan Laboratorium Gagal Ditambahkan Silahkan Cek Jadwal Kembali</a></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span></button>
  </div>
  @elseif(session('status') == 2)
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <span class="alert-inner--icon"><i class="icofont-error"></i></span>
  <span class="alert-inner--text">Penggunaan Laboratorium Gagal Ditambahkan Karena Bertabrakan Dengan Keranjang</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span></button>
</div>
  @endif
@endif  


<div class="card-header border-0">
  <div class="row align-items-center">
    <div class="col-md-4 text-center gbr2 ">
      <?php if(count($bantuan)>1) { $jum = 0; ?>
        <div id="caroselgambar" class="carousel slide @if($jum == 1){{'active'}}@endif" data-ride="carousel" >
        <ol class="carousel-indicators">
           @foreach($bantuan as $b)
          <li data-target="#caroselgambar" data-slide-to="{{$jum}}"></li>
          <?php $jum++; ?>
          @endforeach
        </ol>
        <div class="carousel-inner"  > 
          <?php $jum = 0; ?>
          @foreach($bantuan as $c)
          <div class="carousel-item @if($jum == 1){{'active'}}@endif">
            
            <img class="img-fluid gbr" src='{{asset("img/$c->namafile")}}' alt="Gambar">
          </div>
         
          <?php $jum++; ?>
          @endforeach
        </div>
        <a class="carousel-control-prev" href="#caroselgambar" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#caroselgambar" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    <?php } else if(count($bantuan)== 1){ ?>

       @foreach($bantuan as $c)
        <img class="card-img-top" src='{{asset("img/$c->namafile")}}' alt="Gambar" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'">
       @endforeach
    <?php } else { ?>
          <img class="card-img-top" src='' alt="Gambar" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'">
    <?php }  ?>
    </div>
    @if(isMobile())
    <div class="col-12 text-center">
      <br>
    @else 
    <div class="col-8">
    @endif
      <h1 class="mb-0">{{$lab->namaLab}}</h1>
      <h3>{{$lab->lokasi}} | {{$lab->fakultas}} <br>Kapasitas : {{$lab->kapasitas}}</h3>
      <br>
      <h4>Kepala Lab / Laboran
      @foreach($laboran as $la)
        <br>{{$la->nama}}
      @endforeach
      </h4>
      <br>
      <h4>Jadwal Penggunaan</h4>
      @foreach($rutin as $r)
        <h4>{{$r->hari." ".$r->jamMulai." - ".$r->jamSelesai}}</h4>
      @endforeach

    </div>
 
  </div>
  
</div>
<br>

<div class="col-12">
  <div class=" text-center justify-content-md-center">
    <h1>Gunakan Laboratorium</h1>
    <div id="pesan">
      
    </div>
    <form class="form-grub" id="pinjambarang" method="POST" action="{{url('lab/tambah')}}">
      @csrf
      <div class="row">
        <div class="col-lg-6" style="margin-bottom:5px;">
          <h5>Tanggal</h5>
          <select class="form-control" name="tgl" id="ptgl" required="">
            <option value="" disabled selected>Tanggal Penggunaan</option>
            <?php date_default_timezone_set("Asia/Bangkok");
              for ($i=0; $i < 7 ; $i++) { ?>
                <option value="{{date('d-m-Y', strtotime(date('d-m-Y'). ' + '.$i.' days'))}}">{{date('d-m-Y', strtotime(date('d-m-Y'). ' + '.$i.' days'))}}</option>
            <?php }?>
          </select>
        </div>
        <div class="col-lg-3" style="margin-bottom:5px;">
          
          <h5>Waktu Mulai</h5>
          <select class="form-control" name="wktmul" id="pmulai" required="">
            <option value="" disabled selected>Waktu Mulai</option>
          </select>
        </div>
        <div class="col-lg-3" style="margin-bottom:5px;">
          <h5>Waktu Selesai</h5>

          <select class="form-control" name="wktsel" id="pselesai" required="">
            <option value="" disabled selected>Waktu Selesai</option>
          </select>
        </div>
      </div>
      <br>
      <input type="hidden" name="idlab" value="{{$lab->idlab}}">
      <input id="btnsum" type="submit" name="sum" class="btn btn-fik" value="Masukkan Ke Keranjang" style="width: 100%;">
    </form>
  </div>

  <hr style="width:75%; text-align:center;">
  <h1 class="text-center">Cek Ketersediaan </h1>
  <div class="row text-center justify-content-md-center" >
    
    <br><br><br>
    
     <select class="form-control" name="tgl" id="tgl" >
          <?php date_default_timezone_set("Asia/Bangkok");
            for ($i=0; $i < 7 ; $i++) { ?>
              <option value="{{date('d-m-Y', strtotime(date('d-m-Y'). ' + '.$i.' days'))}}">{{date('d-m-Y', strtotime(date('d-m-Y'). ' + '.$i.' days'))}}</option>
          <?php }?>
      </select>
    
      <br><br><br>
      <div class="table-responsive" id="jadwal">
      <table class="table align-items-center">
          <thead class="thead-light">
              <tr>
                  <th scope="col" class="sort" data-sort="name">Waktu</th>
                  <th scope="col" >Status / Sisa Kapasitas</th>
                  <th scope="col" class="sort" data-sort="name">Waktu</th>
                  <th scope="col" >Status / Sisa Kapasitas</th>
              </tr>
          </thead>
          <tbody class="list">
            
              <?php 
              $jum = count($sesi)/2;
              if(count($sesi)%2 == 1) $jum+=1;
              for ($i=0; $i<$jum ; $i++) { 
                 if($sesi[$jum]->mulai != $sesi[$i]->mulai) {?>
                <tr>
                  <td>
                      {{$sesi[$i]->mulai.' - '.$sesi[$i]->selesai}}
                  </td>
                  <td>
                      <?php if($sesi[$i]->status == 0 ) { ?>
                        <span class="badge badge-dot mr-4">
                        <i class="bg-danger"></i>
                        <span class="status">Tidak Tersedia</span>
                      </span>
                      <?php } else if($sesi[$i]->status == 2 ) { ?>
                        <span class="badge badge-dot mr-4">
                        <i class="bg-success"></i>
                        <span class="status">{{$sesi[$i]->kuota}} Tersedia</span>
                      </span>
                      <?php } ?>
                  </td>
                  <?php 

                    if(!isset($sesi[$i+$jum])) { 
                     echo"<td></td><td></td>"; 
                   } else {
                  ?>
                   <td>
                      {{$sesi[$i+$jum]->mulai.' - '.$sesi[$i+$jum]->selesai}}
                  </td>
                  <td>
                     <?php if($sesi[$i+$jum]->status == 0 ) { ?>
                        <span class="badge badge-dot mr-4">
                        <i class="bg-danger"></i>
                        <span class="status">Tidak Tersedia</span>
                      </span>
                      <?php } else if($sesi[$i+$jum]->status == 2 ) { ?>
                        <span class="badge badge-dot mr-4">
                        <i class="bg-success"></i>
                        <span class="status">{{$sesi[$i+$jum]->kuota}} Tersedia</span>
                      </span>
                      <?php } ?>
                  </td>
                  </tr> 
              <?php } } } ?>
              @foreach($sesi as $s)
              
                  
              @endforeach
              
              </tbody>
            </table>
  </div>
  <hr style="width:75%; text-align:center;" style="margin-bottom: 5px;">
  <div style="width: 100%" class="wrap">
  <span class="wrap badge badge-dot"><i class="bg-success"></i></span>Tersedia | Laboratorium Dapat Digunakan<br>
  <span class="wrap badge badge-dot "><i class="bg-danger"></i></span> Tidak Tersedia | Laboratorium Tidak Dapat Dipinjam Atau Kapasitas Penuh<br>
  </div>
</div>

</div>

</div>

</div>
 </div></div>
<script>
  $(function() {
    var div = $('.gbr2');
    var width = div.width();
    
    $('.gbr').css('height', width);
  });

  $('#tgl').on('change', function() {
    $('#jadwal').empty();
    $('#jadwal').append('<div class="spinner-border text-fik" role="status"></div><br><br><h3>Loading....</h3> ');
    $.ajax({
        type: "GET",
        url: "{{url('lab/jadwal')}}",
        data: {
            'lab': '{{$lab->idlab}}',
            'tgl': this.value
        },
        success: function(data) {
            $('#jadwal').empty();
            $('#jadwal').append(data);
        }
    });
  });

  $('#tutup').on('click', function() {
      $('#modal-default1').modal('hide');
  });

  $('#buka').on('click', function() {
      $('#modal-default1').modal('show');
  });

  $('#ptgl').on('change', function() {
    $('#pmulai').empty();
    $('#pselesai').empty();
    $('#pmulai').append('<option value="" disabled selected>Waktu Mulai</option>');
     $('#pselesai').append('<option value="" disabled selected>Waktu Selesai</option>');
    //$('#btnsum').value('<div class="spinner-border text-fik" role="status"></div><br><br><h3>Loading....</h3> ');
    $.ajax({
        type: "GET",
        url: "{{url('lab/tgl')}}",
        data: {
            'lab': '{{$lab->idlab}}',
            'tgl': this.value
        },
        success: function(data) {
          data.forEach(myFunction);
          function myFunction(item) {
            if(item['status']==2)
            {
              $('#pmulai').append('<option value="'+item['mulai']+'">'+item['mulai']+'</option>');
            }
          }
          $('#pmulai').selectedIndex = "0";
          $('#pselesai').selectedIndex = "0";
        }
    });
  });

  $('#pmulai').on('change', function() {
    $('#pselesai').empty();
    $('#pselesai').append('<option value="" disabled selected>Waktu Selesai</option>');
    $.ajax({
        type: "GET",
        url: "{{url('lab/tgl')}}",
        data: {
            'lab': '{{$lab->idlab}}',
            'tgl': $('#ptgl').val(),
            'mulai': this.value
        },
        success: function(data) {
          data.forEach(myFunction1);
          function myFunction1(item) {
            if(item['status']==2 )
            {
              $('#pselesai').append('<option value="'+item['selesai']+'">'+item['selesai']+'</option>');
            }
          }
          $('#pselesai').selectedIndex = "0";
        }
    });
  });
 

</script>
     
@endsection