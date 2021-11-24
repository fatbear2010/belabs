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
<div class="card-header border-0" id="halo">
  <div class="row align-items-center">
    <div class="col-12 text-center">
      <h1>Pengambilan Barang</h1>
      <h1>Nomor Pesanan : {{$orderku[0]->idorder}}</h1>
      <h3>Waktu Pesanan Dibuat : {{$orderku['0']->tanggal}}</h3>

       @if(session('status'))
          @if(session('status') == 1)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Item Berhasil Dibatalkan</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
        @elseif(session('status') == 4)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Persetujuan Berhasil Disimpan</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
        @elseif(session('status') == 5)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Data Pengambilan Item / Kehadiran Masuk Berhasil Disimpan</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
         @elseif(session('status') == 10)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Pengajuan Pengembalian Item / Kehadiran Keluar Berhasil Disimpan</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
         @elseif(session('status') == 11)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Pengembalian Barang Berhasil Dibatalkan</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
        @elseif(session('status') == 12)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Tanggapan Pengembalian Barang / Kehadiran Keluar Berhasil Disimpan</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
        @elseif(session('status') == 8)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Pengambilan Item / Kehadiran Berhasil Dikonfirmasi Oleh Pemesan</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
         @elseif(session('status') == 6)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-inner--text">Perubahan Data Pengambilan Item / Kehadiran Masuk Berhasil Disimpan</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        </div>
          @elseif(session('status') == 3)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="icofont-error"></i></span>
          <span class="alert-inner--text">Password Salah</a></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          </div>
           @elseif(session('status') == 9)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="icofont-error"></i></span>
          <span class="alert-inner--text">Anda Tidak Memiliki Akses Fitur Ini</a></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          </div>
          @elseif(session('status') == 7)
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span class="alert-inner--icon"><i class="icofont-error"></i></span>
              <span class="alert-inner--text">Kode Pengambilan Salah Atau Pengambilan Telah Dikonfirmasi</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            </div>
          @elseif(session('status') == 2)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="alert-inner--icon"><i class="icofont-error"></i></span>
          <span class="alert-inner--text">Beberapa Item Sudah Tidak Tersedia</span>
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
        <div class="card-header text-left">
            <h2>Identitas Pemesan</h2><span class="font-weight-light"></span>
        </div>
        <div class="row" style="margin: 5px 10px 5px 10px;">
            <div class="col-lg-2 text-center" >
              @if(auth()->user()->jabatan1()->nama == "Mahasiswa")
              <img alt="" style="max-width:100%; max-height:150px; " onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"  src="https://my.ubaya.ac.id/img/mhs/{{auth()->user()->nrpnpk}}_m.jpg">
              @else
              <img alt="" style="max-width:100%; max-height:150px;" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'" src="https://my.ubaya.ac.id/img/krywn/{{auth()->user()->nrpnpk}}_m.jpg">
              @endif
          </div>
            <div class="col-lg-10 text-left table-responsive">
                <table class="table wrap">
                  <tr><td >NRP/NPK</td><td><b>{{ $pemesan[0]->nrpnpk }}</b></td></tr>
                  <tr><td>Nama Lengkap</td><td><b>{{ $pemesan[0]->nama }}</b></td></tr>
                  <tr><td>Jurusan , <br> Fakultas</td><td><b>{{ $pemesan[0]->jurusan1()->namaJurusan}} <br> {{$pemesan[0]->fakultas1()->namafakultas }}</b></td></tr>
                  <tr><td>Jabatan</td><td><b>{{$pemesan[0]->jabatan1()->nama}}</b></td></tr>
                  <tr><td>Email</td><td><b>{{ $pemesan[0]->email }}</b></td></tr>
                  <tr><td>No Telp</td><td><b>{{ $pemesan[0]->notelp }}</b></td></tr>
                  <tr><td>Line ID</td><td><b>{{ $pemesan[0]->lineid }}</b></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Dosen Penanggungjawab</h2><span class="font-weight-light"></span>
        </div>
        <div class="row" style="margin: 5px 10px 5px 10px;">
           <div class="col-lg-2 text-center">
                      <img alt="" style="max-width:100%; max-height:150px;" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'" src="https://my.ubaya.ac.id/img/krywn/{{auth()->user()->nrpnpk}}_m.jpg">
                    </div>
                   <div class="col-md-10 text-left table-responsive">
                      <table class="table wrap">
                        <tr><td>NRP/NPK</td><td><b>{{ $dosenpj[0]->nrpnpk }}</b></td></tr>
                        <tr><td>Nama Lengkap</td><td><b>{{ $dosenpj[0]->nama }}</b></td></tr>
                        <tr><td>Jurusan,Fakultas</td><td><b>{{ KeranjangController::jurusan($dosenpj[0]->jurusan)}}</b></td></tr>
                      </table>
                    </div>
        </div>
    </div>

    <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <div class="row">
            <div class="col-12 col-md-5"><h2>Pengambilan Barang / Kehadiran Masuk</h2></div>
            <div class="col-12 col-md-7">
            @if( KeranjangController::laborannya($orderku[0]->idorder,auth()->user()->nrpnpk) > 0)
            <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('ambil/all/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-info float-right">Pengembalian Pesanan / Kehadiran (Laboran/Kalab)</a>
            @endif
            </div>
        </div>
        </div>
        <div class="row" style="margin: 5px 10px 5px 10px;">
            <div class="col-12" >
            @if($orderku[0]->mahasiswa == auth()->user()->nrpnpk )
             
            <br>
                <form method="post" action="{{url('ambil/konfirmasi')}}">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-2">Kode Pengambilan</div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <input minlength="6" maxlength="6" type="password" name="acode" class="form-control" required >
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <input type="hidden" name="idorder" value="{{$orderku[0]->idorder}}">
                            <input type="submit" name="ok" class="btn btn-info text-wrap " value="Cek Kode Pengambilan" style="width: 100%">
                        </div>
                    </div>
                </form>
            @endif

            @if( KeranjangController::laborannya($orderku[0]->idorder,auth()->user()->nrpnpk) > 0 )
            <br>
            <h3>Daftar Pengambilan / Kehadiran Masuk (Kalab / Laboran)</h3>
           
            <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <th>Kode Pengambilan</th><th>Diproses</th><th>Diambil / Hadir</th><th>Kalab / Laboran</th><th>Action</th>
                </thead>
                <tbody class="list">
                    @foreach($ambil as $am)
                    @if(KeranjangController::laborannya2($am->lab,auth()->user()->nrpnpk) != 0)
                    <tr>
                        <td>{{$am->idambilbalik}}<h3>{{$am->abcode}}</h3></td>
                        <td>{{$am->time}}</td>
                        <td class="text-wrap">@if($am->time2 == "") Item Belum Diambil / Belum Hadir @else {{$am->time2}}@endif</td>
                        <td class="text-wrap">{{KeranjangController::cariorang($am->PIC)}} <br>
                            {{ KeranjangController::labaja($am->lab)}}</td>
                        <td>
                            <a href="{{url('ambil/detail/'.$am->idambilbalik)}}" class="text-wrap btn btn-info">Detail</a>
                        </td>
                    </tr>
                    @endif
                     @endforeach
                </tbody>    
            </table>
        </div>
        <br>
            @endif
         @if( $orderku[0]->dosen == auth()->user()->nrpnpk)
            <h3>Daftar Pengambilan / Kehadiran Masuk (Penanggungjawab)</h3>
           
            <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <th>Kode Pengambilan</th><th>Diproses</th><th>Diambil / Hadir</th><th>Kalab / Laboran</th><th>Action</th>
                </thead>
                <tbody class="list">
                    @foreach($ambil as $am)
                    <tr>
                        <td>{{$am->idambilbalik}}</td>
                        <td>{{$am->time}}</td>
                        <td class="text-wrap">@if($am->time2 == "") Item Belum Diambil / Belum Hadir @else {{$am->time2}}@endif</td>
                        <td class="text-wrap">{{KeranjangController::cariorang($am->PIC)}} <br>
                            {{ KeranjangController::labaja($am->lab)}}</td>
                        <td>
                            <a href="{{url('ambil/ambildetaildosen/'.$am->idambilbalik)}}" class="text-wrap btn btn-info">Detail</a>
                        </td>
                    </tr>
                     @endforeach
                </tbody>    
            </table>
        </div>
        <br>
            @endif   
        </div>
        </div>
    </div>
    
    <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <div class="row">
            <div class="col-12 col-md-5"><h2>Pengembalian Barang / Kehadiran Keluar</h2></div>
            <div class="col-12 col-md-7">
            @if( $pemesan[0]->nrpnpk == auth()->user()->nrpnpk)
            <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('balik/all/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-primary float-right">Pengembalian Pesanan / Kehadiran (Pemesan)</a>
            @endif
            </div>
        </div>
        </div>
        <div class="row" style="margin: 5px 10px 5px 10px;">
            <div class="col-12" >
            @if($orderku[0]->mahasiswa == auth()->user()->nrpnpk )
             
            <br>
                <h3>Daftar Pengambilan / Kehadiran (Pemesan)</h3>
           
            <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <th>Kode Pengambilan</th><th>Diproses</th><th>Dikonfirmasi</th><th>Kalab / Laboran</th><th>Action</th>
                </thead>
                <tbody class="list">
                    @foreach($balik as $am)
                    <tr>
                        <td>{{$am->idambilbalik}}<h3>{{$am->abcode}}</h3></td>
                        <td>{{$am->time}}</td>
                        <td class="text-wrap">@if($am->time2 == "") Pengembalian / Kehadiran Keluar Belum Dikonfirmasi @else {{$am->time2}}@endif</td>
                        <td class="text-wrap">{{KeranjangController::cariorang($am->PIC)}} <br>
                            {{ KeranjangController::labaja($am->lab)}}</td>
                        <td>
                            <a href="{{url('balik/balikdetailmhs/'.$am->idambilbalik)}}" class="text-wrap btn btn-primary">Detail</a>
                        </td>
                    </tr>                
                     @endforeach
                </tbody>    
            </table>
        </div>
            @endif

            @if( KeranjangController::laborannya($orderku[0]->idorder,auth()->user()->nrpnpk) > 0 )
            <br>
            <h3>Daftar Pengambilan / Kehadiran (Kalab / Laboran)</h3>
           
            <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <th>Kode Pengambilan</th><th>Diproses</th><th>Dikonfirmasi</th><th>Kalab / Laboran</th><th>Action</th>
                </thead>
                <tbody class="list">
                    @foreach($balik as $am)
                    @if(KeranjangController::laborannya2($am->lab,auth()->user()->nrpnpk) != 0)
                    <tr>
                        <td>{{$am->idambilbalik}}<h3>{{$am->abcode}}</h3></td>
                        <td>{{$am->time}}</td>
                        <td class="text-wrap">@if($am->time2 == "") Pengembalian / Kehadiran Keluar Belum Dikonfirmasi @else {{$am->time2}}@endif</td>
                        <td class="text-wrap">{{KeranjangController::cariorang($am->PIC)}} <br>
                            {{ KeranjangController::labaja($am->lab)}}</td>
                        <td>
                            <a href="{{url('balik/balikdetaillab/'.$am->idambilbalik)}}" class="text-wrap btn btn-primary">Detail</a>
                        </td>
                    </tr>
                    @endif
                     @endforeach
                </tbody>    
            </table>
        </div>
        <br>
            @endif
         @if( $orderku[0]->dosen == auth()->user()->nrpnpk)
            <h3>Daftar Pengambilan / Kehadiran (Penanggungjawab)</h3>
           
            <div class="table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <th>Kode Pengambilan</th><th>Diproses</th><th>Dikonfirmasi</th><th>Kalab / Laboran</th><th>Action</th>
                </thead>
                <tbody class="list">
                    @foreach($balik as $am)
                    <tr>
                        <td>{{$am->idambilbalik}}</td>
                        <td>{{$am->time}}</td>
                        <td class="text-wrap">@if($am->time2 == "") Pengembalian / Kehadiran Keluar Belum Dikonfirmasi @else {{$am->time2}}@endif</td>
                        <td class="text-wrap">{{KeranjangController::cariorang($am->PIC)}} <br>
                            {{ KeranjangController::labaja($am->lab)}}</td>
                        <td>
                            <a href="{{url('balik/balikdetaildosen/'.$am->idambilbalik)}}" class="text-wrap btn btn-primary">Detail</a>
                        </td>
                    </tr>
                     @endforeach
                </tbody>    
            </table>
        </div>
        <br>
            @endif   
        </div>
        </div>
    </div>

   <div class="row text-center" id="keranjang13" style="margin-left: auto; margin-right: auto;">
     <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <div class="row"></div>
            <h2>Item Yang Dipesan</h2>
            @if($orderku[0]->mahasiswa == auth()->user()->nrpnpk)
                <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('order/batalkan/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-danger">Batalkan Pesanan</a>
            @endif
            @if($orderku[0]->dosen == auth()->user()->nrpnpk)
                <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('order/ppj/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-primary">Setujui Pesanan (Penanggungjawab)</a>
            @endif
            @if( KeranjangController::laborannya($orderku[0]->idorder,auth()->user()->nrpnpk) > 0)
                 <a style="margin-bottom: 5px; max-width: 100%;" href="{{url('order/pl/'.$orderku[0]->idorder)}}" class="text-wrap btn btn-info">Setujui Pesanan (Laboran/Kalab)</a>
            @endif
             
            <h5>Keterangan Warna Item:</h5>
            <button style="margin-bottom:10px;" class="btn-sm btn-fik">Sedang Diproses</button>
            <button style="margin-bottom:10px;" class="btn-sm btn-success">Disetujui</button>
            <button style="margin-bottom:10px;" class="btn-sm btn-danger">Tidak Dietujui/Batal</button>
            <button style="margin-bottom:10px;" class="btn-sm btn-primary">Telah Diambil</button>
            <button style="margin-bottom:10px;" class="btn-sm btn-info">Telah Dikembalikan</button>
            <button style="margin-bottom:10px;" class="btn-sm btn-light">Item Bermasalah</button>
        </div>
           @foreach($keranjang as $item)
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
                                <h5>{{$item['barang']}}<br>{{$item['kat']}}<br><br>{{$item['lab']}}<br>{{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                            </div>
                            <div class="row" style="margin-left: 10px;">
                                <a style="margin-bottom:5px; margin-right: 5px;" href="{{ url('barang/detail2/'.$item['id']) }}" class="btn-sm btn-dark"> <i class="icofont-eye-alt"></i> Cek Barang</a>
                            </div>
                            <div style="margin-top: auto; margin-bottom: auto;  text-align:left; min-width: 200px;  ">
                                <div style="padding:10px;">
                                    <h3>Jadwal Peminjaman</h3>
                                    <?php $hitung = 0; ?>
                                     <div class="accordion" id="accordionExample" style="width:100%">
                                    @foreach($item['pinjam'] as $pj)
                                    <div class="card">
                                   
                                        <button 
                                        @if($pj['status'] == 2) class="btn-sm btn-danger text-left " 
                                        @elseif($pj['status'] == 3) class="btn-sm btn-light text-left " 
                                        @elseif($pj['checkout1'] != "") class="btn-sm btn-info text-left " 
                                        @elseif($pj['checkin1'] != "") class="btn-sm btn-primary text-left " 
                                        @elseif($pj['skalab'] == 1 && $pj['sdosen']==1) class="btn-sm btn-success text-left " 
                                        @else class="btn-sm btn-fik text-left " @endif

                                        type="button" data-toggle="collapse" data-target="#z{{$hitung.$item['id']}}" aria-expanded="true" aria-controls="z{{$hitung.$item['id']}}" style="width:100%;">
                                        <div class="row"><div class="col-10">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}} </div><div class="col-1 text-right"><i class="icofont-caret-down"></i></div></div>
                                           
                                        </button>
                                    

                                    <div id="z{{$hitung.$item['id']}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="width:100%; padding-left: 10px;" >
                                        <br>
                                        <div class="row">
                                            <div class="col-4"><h5>Checkin</h5></div>
                                            <div class="col-8"><h5>{{$pj['checkin']}} | {{$pj['checkin1']}}</h4></div>
                                            <div class="col-4"><h5>Checkout</h5></div>
                                            <div class="col-8"><h5>{{$pj['checkout']}} | {{$pj['checkout1']}}</h4></div>
                                            <div class="col-4"><h5>Catatan</h5></div>
                                            <div class="col-8"><h5>{{$pj['masalah']}}</h5></div>
                                            <div class="col-4"><h5>Dosen Penanggungjawab</h5></div>
                                            <div class="col-8"><h5>
                                                @if($pj['sdosen'] == 2) Tidak Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @elseif($pj['sdosen'] == 1) Sudah Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h5></div>
                                            <div class="col-4"><h5>Laboran / Kepala Laboratorium</h5></div>
                                            <div class="col-8"><h5>
                                                @if($pj['skalab'] == 2) Tidak Disetujui {{$pj['statuskalab']}} - {{PinjamController::dosen1($pj['skalab'])->nama}}
                                                @elseif($pj['skalab'] == 1) Sudah Disetujui {{$pj['statusKalab']}} - {{PinjamController::dosen1($pj['statusKalab'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h5></div>
                                            <div class="col-4"><h5>Lainnya</h5></div>
                                            <div class="col-8"><h5>{{$pj['keterangan']}}</h5></div>
                                        </div>
                                        <br>
                                    </div>
                                  </div>
                                    <?php $hitung++; ?>
                                    @endforeach 
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
                                
                                <div class="col-3 md-4" style="position:relative;  overflow: hidden; min-height:200px; width:200px; ">
                                    <img style="position: absolute; margin-left: -50%; width:100%; min-height:200px;" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                                </div>
                                <div class="col-9 md-6">
                                <div style="text-align:left;margin-top: 20px;   ">     
                                    <h3 class="card-title wrap">{{$item['merk']." ".$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['barang']." | ".$item['kat']}}<br><br>{{$item['lab']}}<br>{{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                                        </div>
                                    </div>
                                    <a style="margin-bottom:5px;" href="{{ url('barang/detail2/'.$item['id']) }}" class="btn btn-dark"> <i class="icofont-eye-alt"></i> Cek Barang</a>
                                </div>
                                </div>
                                <div class="col-12">
                                <div style="margin-top: auto; margin-bottom: auto;  text-align:left;  ">
                                    <div style="padding:15px;">
                                        <h3>Jadwal Penggunaan</h3>
                                        <div class="accordion" id="accordionExample" style="width:100%">
                                  @foreach($item['pinjam'] as $pj)  
                                  <div class="card">
                                   
                                        <button 
                                        @if($pj['status'] == 2) class="btn btn-danger text-left " 
                                        @elseif($pj['status'] == 3) class="btn-sm btn-light text-left " 
                                        @elseif($pj['checkout1'] != "") class="btn btn-info text-left " 
                                        @elseif($pj['checkin1'] != "") class="btn btn-primary text-left " 
                                        @elseif($pj['skalab'] == 1 && $pj['sdosen']==1) class="btn btn-success text-left " 
                                        @else class="btn btn-fik text-left " @endif

                                        type="button" data-toggle="collapse" data-target="#y{{$hitung.$item['id']}}" aria-expanded="true" aria-controls="y{{$hitung.$item['id']}}" style="width:100%;">
                                        <div class="row"><div class="col-11">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}} </div><div class="col-1 text-right"><i class="icofont-caret-down"></i></div></div>
                                           
                                        </button>
                                    

                                    <div id="y{{$hitung.$item['id']}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="width:100%; padding-left: 10px;" >
                                        <br>
                                        <div class="row">
                                            <div class="col-4"><h4>Checkin</h4></div>
                                            <div class="col-8"><h4>{{$pj['checkin']}} | {{$pj['checkin1']}}</h4></div>
                                            <div class="col-4"><h4>Checkout</h4></div>
                                            <div class="col-8"><h4>{{$pj['checkout']}} | {{$pj['checkout1']}}</h4></div>
                                            <div class="col-4"><h4>Catatan</h4></div>
                                            <div class="col-8"><h4>{{$pj['masalah']}}</h4></div>
                                            <div class="col-4"><h4>Dosen Penanggungjawab</h4></div>
                                            <div class="col-8"><h4>
                                                @if($pj['sdosen'] == 2) Tidak Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @elseif($pj['sdosen'] == 1) Sudah Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h4></div>
                                            <div class="col-4"><h4>Laboran / Kepala Laboratorium</h4></div>
                                            <div class="col-8"><h4>
                                                @if($pj['skalab'] == 2) Tidak Disetujui {{$pj['skalab']}} - {{PinjamController::dosen1($pj['skalab'])->nama}}
                                                @elseif($pj['skalab'] == 1) Sudah Disetujui {{$pj['statusKalab']}} - {{PinjamController::dosen1($pj['statusKalab'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h4></div>
                                            <div class="col-4"><h4>Lainnya</h4></div>
                                            <div class="col-8"><h4>{{$pj['keterangan']}}</h4></div>
                                        </div>
                                        <br>
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
                                <h5>{{$item['lokasi']}}<br>{{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                            </div>
                            <div class="row" style="margin-left: 10px;">
                                <a style="margin-bottom:5px; margin-right: 5px;" href="{{ url('lab/detail/'.$item['id']) }}" class="btn-sm btn-dark"> <i class="icofont-eye-alt"></i> Cek Laboratorium</a>
                            </div>
                            <div style="margin-top: auto; margin-bottom: auto;  text-align:left; min-width: 200px;  ">
                                <div style="padding:10px;">
                                    <h3>Jadwal Penggunaan</h3>
                                    <?php $hitung = 0; ?>
                                    <div class="accordion" id="accordionExample" style="width:100%">
                                    @foreach($item['pinjam'] as $pj)
                                    <div class="card">
                                   
                                        <button 
                                        @if($pj['status'] == 2) class="btn-sm btn-danger text-left "
                                        @elseif($pj['status'] == 3) class="btn-sm btn-light text-left "  
                                        @elseif($pj['checkout1'] != "") class="btn-sm btn-info text-left " 
                                        @elseif($pj['checkin1'] != "") class="btn-sm btn-primary text-left " 
                                        @elseif($pj['skalab'] == 1 && $pj['sdosen']==1) class="btn-sm btn-success text-left " 
                                        @else class="btn-sm btn-fik text-left " @endif

                                        type="button" data-toggle="collapse" data-target="#y{{$hitung.$item['id']}}" aria-expanded="true" aria-controls="y{{$hitung.$item['id']}}" style="width:100%;">
                                        <div class="row"><div class="col-10">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}} </div><div class="col-1 text-right"><i class="icofont-caret-down"></i></div></div>
                                           
                                        </button>
                                    

                                    <div id="y{{$hitung.$item['id']}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="width:100%; padding-left: 10px;" >
                                        <br>
                                        <div class="row">
                                            <div class="col-4"><h5>Checkin</h5></div>
                                            <div class="col-8"><h5>{{$pj['checkin']}} | {{$pj['checkin1']}}</h5></div>
                                            <div class="col-4"><h5>Checkout</h5></div>
                                            <div class="col-8"><h5>{{$pj['checkout']}} | {{$pj['checkout1']}}</h5></div>
                                            <div class="col-4"><h5>Catatan</h5></div>
                                            <div class="col-8"><h5>{{$pj['masalah']}}</h5></div>
                                            <div class="col-4"><h5>Dosen Penanggungjawab</h5></div>
                                            <div class="col-8"><h5>
                                                @if($pj['sdosen'] == 2) Tidak Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @elseif($pj['sdosen'] == 1) Sudah Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h5></div>
                                            <div class="col-4"><h5>Laboran / Kepala Laboratorium</h5></div>
                                            <div class="col-8"><h5>
                                                @if($pj['skalab'] == 2) Tidak Disetujui {{$pj['skalab']}} - {{PinjamController::dosen1($pj['skalab'])->nama}}
                                                @elseif($pj['skalab'] == 1) Sudah Disetujui {{$pj['statusKalab']}} - {{PinjamController::dosen1($pj['statusKalab'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h5></div>
                                            <div class="col-4"><h5>Lainnya</h5></div>
                                            <div class="col-8"><h5>{{$pj['keterangan']}}</h5></div>
                                        </div>
                                        <br>
                                    </div>
                                  </div>
                                    <?php $hitung++; ?>
                                    @endforeach 
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div id="d{{$item['id']}}" class="col-lg-12 " style="margin-bottom:10px; min-width: 350px; max-height: 90%;">
                        <div class="card rounded" style=" min-width: 380px;">
                            <div style="margin-left: 1px;" class="row rounded-top" >
                                
                                <div class="col-3 md-4" style="position:relative;  overflow: hidden; min-height:200px; width:200px; ">
                                    <img style="position: absolute; margin-left: -50%; width:100%; min-height:200px;" class="card-img" src='{{asset("img/$gambar")}}' alt="Gambar"  onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'"> 
                                </div>
                                <div class="col-9 md-6">
                                <div style="text-align:left;margin-top: 20px;   ">     
                                    <h3>{{$item['nama']}}</h3>
                                    <div class="row" style="margin-left: 5px;">
                                        <div>
                                            <h5>{{$item['lokasi']}}<br>{{ KeranjangController::fakultas($item['fakultas'])}}</h5>
                                        </div>
                                    </div>
                                    <a style="margin-bottom:5px;" href="{{ url('lab/detail/'.$item['id']) }}" class="btn btn-dark"> <i class="icofont-eye-alt"></i> Cek Laboratorium</a>
                                </div>
                                </div>
                                <div class="col-12">
                                <div style="margin-top: auto; margin-bottom: auto;  text-align:left;  ">
                                    <div style="padding:15px;">
                                        <h3>Jadwal Penggunaan</h3>
                                        <div class="accordion" id="accordionExample" style="width:100%">
                                    <?php $hitung = 0; ?>
                                  @foreach($item['pinjam'] as $pj)  
                                  <div class="card">
                                   
                                        <button 
                                        @if($pj['status'] == 2) class="btn btn-danger text-left " 
                                        @elseif($pj['status'] == 3) class="btn btn-light text-left " 
                                        @elseif($pj['checkout1'] != "") class="btn btn-info text-left " 
                                        @elseif($pj['checkin1'] != "") class="btn btn-primary text-left " 
                                        @elseif($pj['skalab'] == 1 && $pj['sdosen']==1) class="btn btn-success text-left " 
                                        @else class="btn btn-fik text-left " @endif

                                        type="button" data-toggle="collapse" data-target="#y{{$hitung.$item['id']}}" aria-expanded="true" aria-controls="y{{$hitung.$item['id']}}" style="width:100%;">
                                        <div class="row"><div class="col-11">{{date("d-m-Y", strtotime($pj['tgl']))." ".$pj['mulai']." - ".$pj['selesai']}} </div><div class="col-1 text-right"><i class="icofont-caret-down"></i></div></div>
                                           
                                        </button>
                                    

                                    <div id="y{{$hitung.$item['id']}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="width:100%; padding-left: 10px;" >
                                        <br>
                                        <div class="row">
                                            <div class="col-4"><h4>Checkin</h4></div>
                                            <div class="col-8"><h4>{{$pj['checkin']}} | {{$pj['checkin1']}}</h4></div>
                                            <div class="col-4"><h4>Checkout</h4></div>
                                            <div class="col-8"><h4>{{$pj['checkout']}} | {{$pj['checkout1']}}</h4></div>
                                            <div class="col-4"><h4>Catatan</h4></div>
                                            <div class="col-8"><h4>{{$pj['masalah']}}</h4></div>
                                            <div class="col-4"><h4>Dosen Penanggungjawab</h4></div>
                                            <div class="col-8"><h4>
                                                @if($pj['sdosen'] == 2) Tidak Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @elseif($pj['sdosen'] == 1) Sudah Disetujui {{$pj['statusDosen']}} - {{PinjamController::dosen1($pj['statusDosen'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h4></div>
                                            <div class="col-4"><h4>Laboran / Kepala Laboratorium</h4></div>
                                            <div class="col-8"><h4>
                                                @if($pj['skalab'] == 2) Tidak Disetujui {{$pj['skalab']}} - {{PinjamController::dosen1($pj['skalab'])->nama}}
                                                @elseif($pj['skalab'] == 1) Sudah Disetujui {{$pj['statusKalab']}} - {{PinjamController::dosen1($pj['statusKalab'])->nama}}
                                                @else  Belum Disetujui @endif
                                            </h4></div>
                                            <div class="col-4"><h4>Lainnya</h4></div>
                                            <div class="col-8"><h4>{{$pj['keterangan']}}</h4></div>
                                        </div>
                                        <br>
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
                    </div>
                    @endif
                    @endif
                </div>
                    @endforeach
    
    </div>
    </div>  

    <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Catatan Pemesanan</h2><span class="font-weight-light"></span>
        </div>
        <?php //dd($orderku); ?>
        <div class="row" style="margin: 5px 10px 5px 10px;">
           <div class="col-lg-12 text-left" style="margin: 10px 10px 10px 10px; min-height: 100px;">
                <h3><b>Catatan Pemesan</b></h4>
                <h4>{{$orderku[0]->notePeminjam}}</h4>
                <br>
                <h3><b>Catatan Dosen Penanggung Jawab</b></h3>
                <h4>{{$orderku[0]->noteDosen}}</h4>
                <br>
                <h3><b>Catatan Laboran / Kepala Laboratorium</b></h3>
                <h4>{{$orderku[0]->noteKalab}}</h4>
                <br>
                <h3><b>Catatan Pengambilan / Kehadiran Masuk</b></h3>
                @foreach($ambil as $am)
                <h4>{{$am->idambilbalik}} | {{$am->note}}</h4>
                @endforeach
                <br>
                <h3><b>Catatan Pengembalian / Kehadiran Keluar</b></h3>
                 @foreach($balik as $bl)
                <h4>{{$bl->idambilbalik}} | {{$bl->note}}</h4>
                @endforeach
                <br>
            </div>
        </div>
    </div>

    <div class="card card-profile shadow " style="width: 100%;">
        <div class="card-header text-left">
            <h2>Riwayat Pesanan</h2><span class="font-weight-light"></span>
        </div>
        <div class="row">
            <div class="col">
                <div class="timeline p-4 block mb-4">
<?php for ($i=count($status)-1; $i > -1 ; $i--) { ?>        
                    <div class="tl-item ">
                        <div class="tl-dot b-fik"></div>
                        <div class="tl-content">
                            <div class="">
                                <h4>{{date("d-m-Y H:i:s" , strtotime($status[$i]->tanggal))}} <br><b>{{$status[$i]->nama}}</b></h4>
                                <h5>{{KeranjangController::cariorang($status[$i]->pic)}}</h5>
                                <h5>{{$status[$i]->keterangan}}</h5>
                            </div>
                        </div>
                    </div>       
<?php } ?>        
                </div>
            </div>
        </div>
    </div>  
    <br>            


</div>
 </div></div>

@endsection