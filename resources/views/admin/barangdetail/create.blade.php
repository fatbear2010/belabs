@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">

            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">Tambah Barang Detail</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" role="form" method="POST" action="{{route('barangdetail.store')}}">
                    @csrf
                    <h6 class="heading-small text-muted mb-4"> &nbsp Ubah Informasi Barang Detail</h6>

                    <div class="pl-lg-4">
                        <div class="form-group">
                            <label for="form-control-label">ID Barang Detail</label>
                            <input type="text" name="txtIDdetail" class="form-control form-control-alternative" id="exampleInputEmail1" required>
                        </div>
                        <div class="form-group">
                            <label>Barang</label>
                            <br>
                            <select class="form-control" name="comboBarang" >
                                @foreach($barang as $b)
                                <option value="{{$b->idbarang}}">{{$b->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="form-control-label">Nama</label>
                            <input type="text" name="txtNama" class="form-control form-control-alternative" id="exampleInputEmail1" required>
                        </div>
                        <div class="form-group">
                            <label for="form-control-label">Merk</label>
                            <input type="text" name="txtMerk" class="form-control form-control-alternative" id="exampleInputEmail1" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Kondisi</label>
                            <br>
                            <select class="form-control" name="txtKondisi">
                                <option value="0">Baik</option>
                                <option value="1">Rusak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Perbaikan</label>
                            <br>
                            <select class="form-control" name="txtPerbaikan">
                                <option value="0">Tidak Diperbaiki</option>
                                <option value="1">Sedang Diperbaiki</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <br>
                            <select class="form-control" name="txtStatus">
                                <option value="0">Tidak Tersedia</option>
                                <option value="1">Tersedia</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Lab</label>
                            <br>
                            <select class="form-control" name="comboLab">
                                @foreach($lab as $l)
                                <option value="{{$l->idlab}}">{{$l->namaLab}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="txtJum1" value="1">
                        <input type="hidden" name="txtJum2" value="1">
                        <input type="hidden" name="txtWkt1" value="1">
                        
                        <!-- category id-->


                        <div class="text-center">
                            <button type="submit" class="btn btn-warning">Submit</button>
                            <button onClick="history.back()" type="button" class="btn btn-outline-warning">Cancel</button>
                        </div>

                    </div>
                </form>
                <div class="portlet-body form">
                </div>
            </div>
        </div>
    </div>
</div>


@endsection