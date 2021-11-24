<!-- Top navbar -->
<?php use App\Http\Controllers\PinjamController; ?>
<?php use App\Http\Controllers\PinjamLabController; ?>
  <?php
  function isMobile1() {
      return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }
  date_default_timezone_set('Asia/Jakarta');
  ?>

<div  class="modal fade modal-default2" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" >
    <div class="modal-dialog modal- modal-dialog-centered" style="max-width: 90%; " role="document">
        <div class="modal-content">
          <div class="modal-body p-0">

            <div class="card bg-secondary shadow border-0">
              <div class="card-body px-lg-5 py-lg-5">

                <h1 class="text-center">Keranjang</h1>
                <div class="row text-center" id="keranjang">
                  @if(session('cart'))
                  @foreach(session('cart') as $item)
                  <?php $gambar = $item['gambar'];?>
                  @if($item['tipe'] == "barang")
                  @if(isMobile1())
                  <div id="a{{$item['id']}}" class="col-lg-12 overflow-auto" style="margin-bottom:10px; min-width: 100px; ">
                        <div class="card" style=" min-width: 100px;">
                            <div style="position:relative;  overflow: hidden; height:100px; ">
                                <img style="top: 50%" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                            </div>
                            <div style="padding:10px 10px 0px 10px; text-align:left;">     
                              <h4 class="card-title wrap">{{$item['merk']." ".$item['nama']}}</h4>
                            </div>
                            <div style="text-align:left; padding:0px 10px 0px 10px;">
                                <h5>{{$item['barang']}}<br>{{$item['kat']}}<br><br>{{$item['lab']}}<br>{{PinjamLabController::fakultas1($item['fakultas'])->namafakultas }}</h5>
                            </div>
                            <div class="row" style="margin-left: 10px;">
                                <a style="margin-bottom:5px; margin-right: 5px;" href="{{ url('barang/detail2/'.$item['id']) }}" class="btn-sm btn-dark"> <i class="icofont-eye-alt"></i> Cek Barang</a>
                                <button onclick="delete2('a{{$item['id']}}');" style="margin-bottom:5px;" class="btn-sm btn-danger"><i class="icofont-ui-delete"></i> Hapus Barang</button>
                            </div>
                            <div style="margin-top: auto; margin-bottom: auto;  text-align:left; min-width: 200px;  ">
                                <div style="padding:10px;">
                                    <h3>Jadwal Peminjaman</h3>
                                    <?php $hitung = 0; ?>
                                    @foreach($item['pinjam'] as $pj)
                                    <div id="c{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}" class="btn-group" role="group" style="margin-bottom:5px;" id="b{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}">
                                        <button class="btn-sm btn-fik"> 
                                            {{$pj['tgl']}} | {{$pj['mulai']." - ".$pj['selesai']}} </button> 
                                            <button onclick="delete1('b{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}','a{{$item['id']}}');" class="btn-sm btn-danger" style=" margin-left:5px;"><i class="icofont-ui-delete"></i> Hapus
                                        </button>
                                        
                                    </div>  
                                    <?php $hitung++; ?>
                                    @endforeach 
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div id="a{{$item['id']}}" class="col-lg-12 overflow-auto" style="margin-bottom:10px; min-width: 350px; max-height: 90%;">
                        <div class="card rounded" style=" min-width: 380px;">
                            <div style="margin-left: 1px;" class="row rounded-top" >
                                <div style="position:relative;  overflow: hidden; height:200px; width:200px; ">
                                    <img style="position: absolute; margin-left: -75%; width:300px;" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                                </div>
                                <div style="padding:15px; text-align:left; width: 40%; ">     
                                    <h3 class="card-title wrap">{{$item['merk']." ".$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['barang']." | ".$item['kat']}}<br><br>{{$item['lab']}}<br>{{PinjamLabController::fakultas1($item['fakultas'])->namafakultas }}</h5>
                                        </div>
                                    </div>
                                    <a style="margin-bottom:5px;" href="{{ url('barang/detail2/'.$item['id']) }}" class="btn btn-dark"> <i class="icofont-eye-alt"></i> Cek Barang</a>
                                    <button onclick="delete2('a{{$item['id']}}');" style="margin-bottom:5px;" class="btn btn-danger"><i class="icofont-ui-delete"></i> Hapus Barang</button>
                                </div>
                                <div style="margin-top: auto; margin-bottom: auto;  text-align:left; ;  ">
                                    <div style="padding:15px;">
                                        <h3>Jadwal Peminjaman</h3>
                                        <div class="">
                                            <?php $hitung = 0; ?>
                                            @foreach($item['pinjam'] as $pj)
                                            <div class="col" id="b{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}">
                                                <div id="c{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}" class="btn-group" role="group" style="margin-bottom:5px;">
                                                    <button class="btn btn-fik" > 
                                                    {{$pj['tgl']." ".$pj['mulai']." - ".$pj['selesai']}} </button> 
                                                    <button onclick="delete1('b{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}','a{{$item['id']}}');" id="b{{$hitung.$item['id']}}" class="btn btn-danger" style=" margin-left:5px;"><i class="icofont-ui-delete"></i> Hapus</button>
                                                  
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
                    @if(isMobile1())
                    <div id="a{{$item['id']}}" class="col-lg-12 overflow-auto" style="margin-bottom:10px; min-width: 100px; ">
                        <div class="card" style=" min-width: 100px;">
                            <div style="position:relative;  overflow: hidden; height:100px; ">
                                <img style="top: 50%" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                            </div>
                            <div style="padding:10px 10px 0px 10px; text-align:left;">     
                              <h4 class="card-title wrap">{{$item['nama']}}</h4>
                            </div>
                            <div style="text-align:left; padding:0px 10px 0px 10px;">
                                <h5>{{$item['lokasi']}}<br>{{PinjamLabController::fakultas1($item['fakultas'])->namafakultas }}</h5>
                            </div>
                            <div class="row" style="margin-left: 10px;">
                                <a style="margin-bottom:5px; margin-right: 5px;" href="{{ url('lab/detail/'.$item['id']) }}" class="btn-sm btn-dark"> <i class="icofont-eye-alt"></i> Cek Laboratorium</a>
                                <button onclick="delete2('a{{$item['id']}}');" style="margin-bottom:5px;" class="btn-sm btn-danger"><i class="icofont-ui-delete"></i> Hapus Laboratorium</button>
                            </div>
                            <div style="margin-top: auto; margin-bottom: auto;  text-align:left; min-width: 200px;  ">
                                <div style="padding:10px;">
                                    <h3>Jadwal Penggunaan</h3>
                                    <?php $hitung = 0; ?>
                                    @foreach($item['pinjam'] as $pj)
                                    <div id="c{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}" class="btn-group" role="group" style="margin-bottom:5px;" id="b{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}">
                                        <button class="btn-sm btn-fik"> 
                                            {{$pj['tgl']}} | {{$pj['mulai']." - ".$pj['selesai']}} </button> 
                                            <button onclick="delete1('b{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}','a{{$item['id']}}');" class="btn-sm btn-danger" style=" margin-left:5px;"><i class="icofont-ui-delete"></i> Hapus
                                        </button>
                                    </div>  
                                    <?php $hitung++; ?>
                                    @endforeach 
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div id="a{{$item['id']}}" class="col-lg-12 overflow-auto" style="margin-bottom:10px; min-width: 350px; max-height: 90%;">
                        <div class="card rounded" style=" min-width: 380px;">
                            <div style="margin-left: 1px;" class="row rounded-top" >
                                <div style="position:relative;  overflow: hidden; height:200px; width:200px; ">
                                    <img style="position: absolute; margin-left: -75%; width:300px;" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                                </div>
                                <div style="padding:15px; text-align:left; width: 40%; ">     
                                    <h3 class="card-title wrap">{{$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['lokasi']}}<br>{{PinjamLabController::fakultas1($item['fakultas'])->namafakultas }}</h5>
                                        </div>
                                    </div>
                                    <a style="margin-bottom:5px;" href="{{ url('lab/detail/'.$item['id']) }}" class="btn btn-dark"> <i class="icofont-eye-alt"></i> Cek Laboratorium</a>
                                    <button onclick="delete2('a{{$item['id']}}');" style="margin-bottom:5px;" class="btn btn-danger"><i class="icofont-ui-delete"></i> Hapus Laboratorium</button>
                                </div>
                                <div style="margin-top: auto; margin-bottom: auto;  text-align:left; ;  ">
                                    <div style="padding:15px;">
                                        <h3>Jadwal Penggunaan</h3>
                                        <div class="">
                                            <?php $hitung = 0; ?>
                                            @foreach($item['pinjam'] as $pj)
                                            <div class="col" id="b{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}">
                                                <div id="c{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}" class="btn-group" role="group" style="margin-bottom:5px;">
                                                    <button class="btn btn-fik" > 
                                                    {{$pj['tgl']." ".$pj['mulai']." - ".$pj['selesai']}} </button> 
                                                    <button onclick="delete1('b{{str_pad($hitung,4,'0',STR_PAD_LEFT).$item['id']}}','a{{$item['id']}}');" id="b{{$hitung.$item['id']}}" class="btn btn-danger" style=" margin-left:5px;"><i class="icofont-ui-delete"></i> Hapus</button>
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
                    @endforeach
                    @else
                    <h3 class="card-title wrap">Keranjang Anda Kosong</h3>
                    @endif
                          @if(count((array) session('cart')) != 0 )
                          <div id="btnkrj" style="width:100%;">
                          <a href="{{url('keranjang/keranjangdetail')}}"><button style="width: 100%; margin-top: 10px;" id="checkout" class="btn btn-fik" >Lihat Keranjang</button></a>
                          <button style="width: 100%; margin-top: 10px;" id="clean" class=" btn btn-dark" >Bersihkan Keranjang</button>
                          </div>
                          @endif
                         <button style="width: 100%; margin-top: 10px;" id="tutup2" class=" btn btn-danger" >Tutup</button>
                        
                          
                      </div> 
                  </div>
              </div> 

          </div>
      </div>
  </div>  
</div>
  <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="">{{auth()->user()->jabatan1()->nama}}</a>
        <!-- Form -->
        @if(1==2)
        <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
            <div class="form-group mb-0">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="form-control" placeholder="Search" type="text">
                </div>
            </div>
        </form>
        @endif
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">

            <li class="nav-item dropdown">
                 @if(!isset($lihat)) 
                <button onclick="cekkeranjang();" type="button" class="btn btn-fik" data-toggle="dropdown" id="buka3">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Keranjang <span id="keranjang1" class="badge badge-pill badge-dark text-light">{{ count((array) session('cart')) }}</span>
                </button>
                @endif
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                    <span class="avatar avatar-sm rounded-circle">
                        @if(auth()->user()->jabatan1()->nama == "Mahasiswa")
                        <img alt="" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'" src="https://my.ubaya.ac.id/img/mhs/{{auth()->user()->nrpnpk}}_m.jpg">
                        @else
                        <img alt="" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'" src="https://my.ubaya.ac.id/img/krywn/{{auth()->user()->nrpnpk}}_m.jpg">
                        @endif
                    </span>
                    <div class="media-body ml-2 d-none d-lg-block">
                        <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->nama }}</span>
                    </div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                </div>
                @if(1==2)
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="ni ni-single-02"></i>
                    <span>{{ __('My profile') }}</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="ni ni-settings-gear-65"></i>
                    <span>{{ __('Settings') }}</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="ni ni-calendar-grid-58"></i>
                    <span>{{ __('Activity') }}</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="ni ni-support-16"></i>
                    <span>{{ __('Support') }}</span>
                </a>
                @endif
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="ni ni-user-run"></i>
                <span>{{ __('Logout') }}</span>
            </a>
        </div>
    </li>
</ul>
</div>
</nav>
<script>

   function delete1(id, ids)
   {
    $.ajax({
        type: "GET",
        url: "{{url('keranjang/hapusPinjam')}}",
        data: {id:id},
        success: function(data) {
            if(data == 1){ $('#'+id).remove(); }
            else if (data == 0) { $('#'+ids).remove(); cekkeranjang(); }
            else if (data == 2) { 
                $('#keranjang1').empty();
                $('#keranjang2').empty();
                $('#keranjang1').append('0');
                $('#keranjang2').append('0');
                $('#keranjang').empty();
                $('#keranjang').append('<h3 class="card-title wrap">Keranjang Anda Kosong</h3> <br> <button style="width: 100%; margin-top: 10px;" id="tutup2" class=" btn btn-danger" onclick="$(\'.modal-default2\').modal(\'hide\');" >Tutup</button>');
            }
            else {}
        }
    });   
   }


   function cekkeranjang()
   {
    <?php $hitung2 = 0; $hitung3 = 0; $hitung4 =0;?>
    @if(session('cart')!=null)
     @foreach(session('cart') as $item)
        @foreach($item['pinjam'] as $pj)
        <?php 
            if($item['tipe'] == "barang")
            {
                if(PinjamController::cekada($item['id'],$pj['tgl'],$pj['mulai'],$pj['selesai'])==1 ){ ?>
                @if(isMobile1())
                    $('#c{{str_pad($hitung2,4,'0',STR_PAD_LEFT).$item['id']}}').append(
                        '<button class="btn-sm text-danger"style=" margin-left:5px;" >'+ 
                        '<i class="icofont-warning"></i> Item Tidak Tersedia</button>');
                @else
                    $('#c{{str_pad($hitung2,4,'0',STR_PAD_LEFT).$item['id']}}').append(
                        '<button class="btn text-danger"style=" margin-left:5px;" >'+ 
                        '<i class="icofont-warning"></i> Item Tidak Tersedia</button>');
                @endif                    
                <?php $hitung4++;  }
                $hitung2++;    
            }
            else if($item['tipe'] == "lab")
            {
                if(PinjamLabController::cekada($item['id'],$pj['tgl'],$pj['mulai'],$pj['selesai'])==1 ){ ?>
                @if(isMobile1())
                    $('#c{{str_pad($hitung3,4,'0',STR_PAD_LEFT).$item['id']}}').append(
                        '<button class="btn-sm text-danger"style=" margin-left:5px;" >'+ 
                        '<i class="icofont-warning"></i> Item Tidak Tersedia</button>');
                @else
                    $('#c{{str_pad($hitung3,4,'0',STR_PAD_LEFT).$item['id']}}').append(
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
     if( hasil != 0) { $('#checkout').prop('disabled', true); }   
     else { $('#checkout').prop('disabled', false); }   
   }
   function delete2(id)
   {
     $.ajax({
        type: "GET",
        url: "{{url('keranjang/hapusBarang')}}",
        data: {id:id},
        success: function(data) {
            if(data == 1){ $('#'+id).remove(); cekkeranjang(); }
            else if (data == 2) { 
                $('#keranjang1').empty();
                $('#keranjang2').empty();
                $('#keranjang1').append('0');
                $('#keranjang2').append('0');
                $('#keranjang').empty();
                $('#keranjang').append('<h3 class="card-title wrap">Keranjang Anda Kosong</h3> <br> <button style="width: 100%; margin-top: 10px;" id="tutup2" class=" btn btn-danger" onclick="$(\'.modal-default2\').modal(\'hide\');" >Tutup</button>');
            }
            else {}; 
        }
    }); 
   }

    $('#tutup2').on('click', function() {
      $('.modal-default2').modal('hide');
  });


    $('#buka2').on('click', function() {
      $('.modal-default2').modal('show');
  });

    $('#buka3').on('click', function() {
      $('.modal-default2').modal('show');
  });

$('#clean').on('click', function() {
    $('#keranjang').empty();
    $('#btnkrj').empty();
    $('#keranjang').append('<div class="spinner-border text-fik" role="status"></div><br><br><h3>Loading....</h3> ');
    $.ajax({
        type: "GET",
        url: "{{url('keranjang/clean')}}",
        data: {},
        success: function(data) {
            $('#keranjang1').empty();
            $('#keranjang2').empty();
            $('#keranjang1').append('0');
            $('#keranjang2').append('0');
            $('#keranjang').empty();
            $('#keranjang').append('<h3 class="card-title wrap">Keranjang Anda Kosong</h3> <br> <button style="width: 100%; margin-top: 10px;" id="tutup2" class=" btn btn-danger" onclick="$(\'.modal-default2\').modal(\'hide\');" >Tutup</button>');
        }
    });   
});

</script>