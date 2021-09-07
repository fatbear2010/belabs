@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
            <!--div -->

            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">BARANG DETAIL</h3>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{route('barang.create')}}" class="btn btn-warning">Tambah Barang Detail</a>
                    </div>
                </div>
            </div>

            <div class="col-12">
            </div>

            <div class="table-responsive">

                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">ID Barang Detail</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Kondisi</th>
                            <th scope="col">Perbaikan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Lab</th>
                            <th scope="col">Jumlah Pakai</th>
                            <th scope="col">Durasi Pakai</th>
                            <th scope="col">Waktu Pakai</th>
                            <th scope="col">Gambar</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($queryBuilder as $d)
                        <tr>
                            <td>{{ $d->idbarangDetail }}</td>
                            <td>{{ $d->idbarang }}</td>
                            <td>{{ $d->merk }}</td>
                            <td>{{ $d->kondisi }}</td>
                            <td>{{ $d->perbaikan }}</td>
                            <td>{{ $d->status }}</td>
                            <td>{{ $d->lab }}</td>
                            <td>{{ $d->jumPakai }}</td>
                            <td>{{ $d->durasiPakai }}</td>
                            <td>{{ $d->wktPakai1 }}</td>
                            <td><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal_{{$d->idbarangDetail}}">
                                    Show Gambar
                                </button></td>

                            <div class="modal fade" id="exampleModal_{{$d->idbarangDetail}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Gambar Barang</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="carouselExampleIndicators_{{$d->idbarangDetail}}" class="carousel slide" data-ride="carousel">
                                                <?php
                                                $total = count($d->gambars);
                                                ?>
                                                <ol class="carousel-indicators">
                                                    @for($i=0;$i<$total;$i++) <li data-target="#carouselExampleIndicators_{{$d->idbarangDetail}}" data-slide-to="{{$i}}" @if($i===0)class="active" @endif>
                                                        </li>
                                                        @endfor
                                                </ol>

                                                <div class="carousel-inner">
                                                    @foreach($d->gambars as $key=>$g)

                                                    <div class="carousel-item @if($key===0) active @endif">
                                                        <img class="d-block w-100" src='{{asset("img/$g->namafile")}}' alt="First slide">
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleIndicators_{{$d->idbarangDetail}}" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleIndicators_{{$d->idbarangDetail}}" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>

                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="{{route('barangdetail.edit',$d->idbarangDetail)}}">Edit</a>
                                        <form method='Post' action="{{route('barangdetail.destroy',$d->idbarangDetail)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" value="delete" onclick="if(!confirm('Yakin Hapus??'))return false;" class="dropdown-item" href="">Delete</a>
                                        </form>
                                    </div>
                                </div>
                            </td>

                            @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection