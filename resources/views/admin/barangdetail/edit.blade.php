@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">

            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">Edit Barang Detail</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" role="form" method="POST" action="{{route('barangdetail.update',$data->idbarangDetail)}}">
                    @csrf
                    @method("PUT")
                    <h6 class="heading-small text-muted mb-4"> &nbsp Ubah Informasi Barang Detail</h6>

                    <div class="pl-lg-4">
                        <div class="form-group">
                            <label for="form-control-label">Merk</label>
                            <input type="text" name="txtMerk" class="form-control form-control-alternative" id="exampleInputEmail1" value="{{$data->merk}}" required>
                        </div>
                        <div class="form-group">
                            <label for="form-control-label">Kondisi</label>
                            <input type="text" name="txtKondisi" class="form-control form-control-alternative" id="exampleInputEmail1" value="{{$data->kondisi}}" required>
                        </div>
                        <div class="form-group">
                            <label for="form-control-label">Perbaikan</label>
                            <input type="text" name="txtPerbaikan" class="form-control form-control-alternative" id="exampleInputEmail1" value="{{$data->perbaikan}}" required>
                        </div>
                        <div class="form-group">
                            <label for="form-control-label">Status</label>
                            <input type="text" name="txtStatus" class="form-control form-control-alternative" id="exampleInputEmail1" value="{{$data->status}}" required>
                        </div>
                        <div class="form-group">
                            <label>Lab</label>
                            <br>
                            <select class="form-control" name="comboLab" value="{{$lab[0]->idlab}}">
                                @foreach($lab as $l)
                                <option value="{{$l->idlab}}">{{$l->namaLab}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="form-control-label">Jumlah Pakai(kali)</label>
                            <input type="text" name="txtJum1" class="form-control form-control-alternative" id="exampleInputEmail1" value="{{$data->jumPakai}}" required>
                        </div>
                        <div class="form-group">
                            <label for="form-control-label">Durasi Pakai(...jam)</label>
                            <input type="text" name="txtJum2" class="form-control form-control-alternative" id="exampleInputEmail1" value="{{$data->durasiPakai}}" required>
                        </div>
                        <div class="form-group">
                            <label for="form-control-label">Waktu Pakai (/hari)</label>
                            <input type="text" name="txtWkt1" class="form-control form-control-alternative" id="exampleInputEmail1" value="{{$data->wktPakai1}}" required>
                        </div>
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