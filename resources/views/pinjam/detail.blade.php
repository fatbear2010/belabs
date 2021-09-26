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
      <h1 class="mb-0">{{$barang->nama}}</h1>
      <h1 class="mb-0">({{$kategori[0]->nama}})</h1>
      <h3>Silahkan Pilih Varian Yang Tersedia</h3>
      <br>
    </div>
  </div>
</div>
<br>

              <div class="card-body px-lg-5 py-lg-5">
                 <div class="row text-center ">
                  @foreach($barangdt as $b)
                  @if(isMobile())
  

                   <?php $lab = PinjamController::lab($b->lab); ?>
                  <div class="card gbr2" style="margin: -35px 5px 40px 5px ;  width: 45%;" >
                    <a href="{{ url('barang/detail2/'.$b->idbarangDetail) }}">
                      <div style="position:relative;  overflow: hidden; height:100px; border-radius: 10px 10px 0px 0px;">
                           <img style="" class="card-img" src='{{asset("img/".PinjamController::gambardt($b->idbarangDetail))}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'">
                      </div>
                      <?php $lab = PinjamController::lab($b->lab); ?>
                      <div style="padding:15px; text-align:center;">     
                          <h5 class="card-title">{{$b->merk." - ".$b->nama}}</h5>
                          <h6>{{$lab->namaLab}}<br>{{$lab->fakultas}}</h6>
                      </div>
                   </a>
                  </div>
                  @else
                  <div class="col-lg-6" style="margin-bottom:10px; min-width: 350px;">
                  <div class="card" style=" min-width: 380px;">
                    <a href="{{ url('barang/detail2/'.$b->idbarangDetail) }}">
                      <div style="margin-left: 1px;" class="row" >
                      <div style="position:relative;  overflow: hidden; height:125px; width: 125px; border-radius: 10px 0px 0px 10px;">
                           <img style="height:125px; width: auto; " class="card-img" src='{{asset("img/".PinjamController::gambardt($b->idbarangDetail))}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'">
                      </div>
                      <?php $lab = PinjamController::lab($b->lab); ?>
                      <div style="padding:15px; text-align:left; max-width: 80%;">     
                          <h3 class="card-title wrap">{{$b->merk." - ".$b->nama}}</h3>
                          <h4>{{$lab->namaLab}}<br>{{$lab->fakultas}}</h4>
                      </div>
                      </div>
                   </a>
                  </div>
                  </div>
                  @endif
                  @endforeach
                </div> 
              </div>
         <br>
<h4 class="text-center">Anda telah Melihat Semua Item Yang Tersedia</h4>
<br><br>

</div>
</div>
</div>
 </div></div>

@endsection