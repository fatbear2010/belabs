<?php 
use App\Http\Controllers\PinjamController; 
use App\Http\Controllers\KeranjangController; 


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
    <div class="col-12 text-center">
      <h1 class="mb-0" >Barang Dipinjam Dan Barang Bermasalah</h1>
      <br>
      <form class="form" style="width: 100%"  class="text-left" action="{{url('item/out')}}" method="post">
        @csrf
        <div class="row" class="text-left">
          <div class="col">
            <h4 class="text-left">Filter Pesanan</h4>
            <div class="form-group">
              <select id="" class="form-control" name="k" style="width: 100%">
               <option @if($k == 1) selected @endif value="1">Semua Pesanan</option>
               @foreach($labnya as $l)
               <option @if($k == 'l'.$l->lab) selected @endif value="l{{$l->lab}}" > Pesanan Pada {{KeranjangController::labaja($l->lab)}}</option>
               @endforeach
             </select>  
           </div>
          </div>
        </div>
        <div class="row">
          <input type="hidden" name="filter" value="1">
          <input type="submit" name="sum" value="Gunakan Filter" class="btn btn-fik" style="width:100%; margin-left: 10px; margin-right: 10px;">
        </div>
     </form>
    </div>
 
  </div>
  
</div>
<br>
<div class="col-12">
  
  <div class="row justify-content-md-center" >
     <div class="card card-profile shadow " style="width: 98%;">
            <div class="overflow-auto">
            <?php for($i = 0; $i<count($barang); $i++) {  ?>
                <div class="row" style="margin: 20px 20px 5px 20px;">
                    <div class="col-md-9" >
                            <table>
                                <tr>
                                    <td>
                                         <h3>{{$barang[$i]->idorder}} </h3>
                                          <h2>{{KeranjangController::cariorang($barang[$i]->mahasiswa)}} </h2>
                                    </td>
                                    <td>
                                      <div class="dropdown" >
                                          <p class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="showorder1({{$barang[$i]->idorder}});">
                                          </p>
                                          <div id="b{{$barang[$i]->idorder}}" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 350px;">
                                            <div>
                                             <table><tr><td style="padding-left: 20px;"><div class="spinner-border text-fik" role="status"></div></td><td style="padding-left: 10px;"><h3>Loading....</h3></td></tr></table>
                                            </div> 
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr><td><h4>Pesanan Dibuat  : {{date("d-m-Y H:i:s",strtotime($barang[$i]->tanggal))}} </h4></td></tr>
                        </table>
                        
                          </div>
                    <div class="col-md-3">
                    <a href="{{url('order/detail/'.$barang[$i]->idorder)}}" class="btn btn-fik">Lihat Detail Pesanan</a>
                </div> 
            </div> 
              <?php } ?>             
        </div></div>
    
  </div>
</div>

</div>



</div>

</div>
 </div></div>
 <script type="text/javascript">
        function showorder1(a)
        {
            $.ajax({
            type: "GET",
            url: "{{url('order/showorder')}}",
            data: {ido:a},
                success: function(data) {
                    $('#b'+a).empty();
                    $('#b'+a).append(data);
                }
            });  
        }
    </script>
@endsection