<?php use App\Http\Controllers\PinjamLabController; 

?>
  <?php
  function isMobile() {
      return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }
  ?>
@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="row">
  <div class="col-md-12">
    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
      @if(isMobile())
          <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
      @else
          <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
      @endif
        <div class="modal-content">
          <div class="modal-body p-0">
            	              	
            <div class="card bg-secondary shadow border-0">
              <div class="card-body px-lg-5 py-lg-5">
                <h1 class="text-center">Filter</h1>
                <form class="form-group row" action="{{route('lab.filter')}}" method="post" style="width: 100%; margin-left: auto; margin-right:auto;">
                  @csrf
                  <h5>Nama Laboratorium</h5>
                  <input type="text" class="form-control" name="nama">
                  <br><br>
                  <h5>Fakultas</h5>
                  <select class="form-control" name="fakultas">
                    <option value="ALL" selected="">Semua Fakultas</option>
                    @foreach($fak as $l)
                    <option value="{{$l->fakultas}}" >{{$l->fakultas}}</option>
                    @endforeach
                  </select>
                  <br><br>
                  <h5>Dapat Digunakan Pada Tanggal</h5>
                  <select class="form-control" name="tgl">
                    <option value="ALL" selected="">Semua Hari</option>
                     <?php 
                      date_default_timezone_set("Asia/Bangkok");
                      for ($i=0; $i < 7 ; $i++) { ?>
                       <option value="">{{date('d-m-Y', strtotime(date('d-m-Y'). ' + '.$i.' days'))}}</option>
                     <?php }?>
                  </select>
                   <br><br>
                  <h5>Dapat Digunakan Pada Jam</h5>
                  <br>
                  <div class="row" style="width: 100%;">
                    <div class="col-md-5">
                  <select class="form-control" name="jammul">
                    <option value="ALL" selected="">Semua Jam</option>
                     @foreach($sesi as $s)
                    <option value="{{$s->mulai}}">{{$s->mulai}}</option>
                     @endforeach
                  </select>
                   </div><div class="col-md-2">
                    <h5 class="text-center">Sampai</h5>
                </div><div class="col-md-5">
                  <select class="form-control" name="jamsel" style="margin-bottom: 10px;">
                    <option value="ALL" selected="">Semua Jam</option>
                       @foreach($sesi as $s)
                    <option value="{{$s->selesai}}">{{$s->selesai}}</option>
                     @endforeach
                  </select>
                  </div></div>
                  <br><br>
                  <input style="width: 100%;" type="submit" class="btn btn-fik" name="submit" value="Gunakan Filter">
                </form>
                  <button style="width: 100%;" class="btn btn-danger" id="tutup">Tutup</button>

              </div>
            </div>
   
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="container-fluid mt--7">
  <div class="row">
      <div class="col-xl-12 mb-5 mb-xl-0">
<!--div -->


<div class="card-header border-0" style="margin:10px;">
  <div class="row align-items-center">
    <div class="col-11 text-center">
      <h1 class="mb-0" >Penggunaan Laboratorium</h1>
      <br>
       <div class="row text-center justify-content-md-center">
         <div class="btn-group flex-wrap" role="group" >
          @if(isMobile())
              <button class="btn-sm btn-dark">Filter</button> 
             @if(!isset($filter))
              <button class="btn-sm btn-fik" >Tidak Ada Filter Digunakan</button>
            @else
              @if(isset($filter['nama']))
                <button class="btn-sm btn-light">Nama Lab : {{$filter['nama']}}</button>
              @endif
              @if(isset($filter['fakultas']))
                <button class="btn-sm btn-success">Fakultas : {{$filter['fakultas']}}</button>
              @endif
              @if(isset($filter['tgl']))
                <button class="btn-sm btn-danger">Tanggal : {{$filter['tgl']}}</button>
              @endif
              @if(isset($filter['jamul']) && isset($filter['jamsel']))
                <button class="btn-sm btn-primary">Waktu : Mulai {{$filter['jammul']}} Hingga {{$filter['jammul']}}</button>
              @elseif(isset($filter['jamul']))
                <button class="btn-sm btn-primary">Waktu : Mulai {{$filter['jammul']}}</button>
              @elseif(isset($filter['jamul']))
                <button class="btn-sm btn-primary">Waktu : Hingga {{$filter['jammul']}}</button>
              @endif
            </div>
            @endif
          @else
            <button class="btn btn-dark">Filter : </button> 
            @if(!isset($filter))
              <button class="btn btn-fik">Tidak Ada Filter Digunakan</button>
            @else
              @if(isset($filter['nama']))
                <button class="btn btn-light">Nama Lab : {{$filter['nama']}}</button>
              @endif
              @if(isset($filter['fakultas']))
                <button class="btn btn-success">Fakultas : {{$filter['fakultas']}}</button>
              @endif
              @if(isset($filter['tgl']))
                <button class="btn btn-danger">Tanggal : {{$filter['tgl']}}</button>
              @endif
              @if(isset($filter['jamul']) && isset($filter['jamsel']))
                <button class="btn btn-primary">Waktu : Mulai {{$filter['jammul']}} Hingga {{$filter['jammul']}}</button>
              @elseif(isset($filter['jamul']))
                <button class="btn btn-primary">Waktu : Mulai {{$filter['jammul']}}</button>
              @elseif(isset($filter['jamul']))
                <button class="btn btn-primary">Waktu : Hingga {{$filter['jammul']}}</button>
              @endif
            @endif
          @endif
        </div></div>
      
      <br>
    </div>
 
  </div>
  
</div>
<br><br>

<?php //dd(PinjamController::gambar('1x')); ?>
<div class="col-12">
  
  <div class="row text-center justify-content-md-center"  >
   
    @foreach($lab as $l)
    @if(isMobile())
    
    <div class="card gbr2" style="margin: -35px auto 40px auto ;  width: 45%;" >
      <a href="{{ url('lab/detail/'.$l->idlab) }}">
      <div style="position:relative;  overflow: hidden; height:100px; border-radius: 10px 10px 0px 0px;">
      <img class="card-img-top gbr" src='{{asset("img/".PinjamLabController::gambar($l->idlab))}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'">
      </div>
      <div class="card-body">
        <h5 >{{$l->namaLab}}</h5>
        <h6 >{{$l->lokasi}}<br>{{$l->fakultas}}</h6>
      </div></a>
    </div>
   
    @else
    <div class="card" style="margin: 5px; max-with:10%; width: 17rem; border-radius: 10px" >
      <a href="{{ url('lab/detail/'.$l->idlab) }}">
      <div style="position:relative;  overflow: hidden; height:300px; border-radius: 10px 10px 0px 0px; ">
      <img style="position: absolute; height: 300px; width: auto; margin-left: -50%;" class="card-img-top" src='{{asset("img/".PinjamLabController::gambar($l->idlab))}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'">
    </div>
      <div class="card-body">
        <h3 >{{$l->namaLab}}</h3>
        <h4 >{{$l->lokasi}}<br>{{$l->fakultas}}</h4>
      </div></a>
    </div>
    @endif
    @endforeach
  </div>
  <button style="bottom: 5%; right: 50px; border-radius: 50px;" class=" position-fixed btn btn-fik " id="buka"><div class="text-center"><i class="icofont-settings"></i> Filter</div></button>
</div>

<br>
<h4 class="text-center">Anda telah Melihat Semua Laboratorium Yang Tersedia</h4>
<br><br>

</div>



</div>

</div>
 </div></div>
<script>
  

$('#tutup').on('click', function() {
      $('#modal-default').modal('hide');
  });

  $('#buka').on('click', function() {
      $('#modal-default').modal('show');
  });

</script>
@endsection