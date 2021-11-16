@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--7">
  <div class="row">
      <div class="col-xl-12 mb-5 mb-xl-0">

<div class="card-header border-0">
  <div class="row align-items-center">
    <div class="col-12 col-md-8">
      <h3 class="mb-0">STATUS JABATAN</h3>
    </div>
    <div class="col-12 col-md-4 text-right">
      <a href="{{route('statusjabatan.create')}}" class="btn btn-warning">Tambah STATUS Jabatan</a>
    </div>
  </div>
</div>

<div class="col-12">
</div>

<div class="table-responsive">
  <table class="table align-items-center table-flush" ;">
    <thead class="thead-light">
      <tr style="width:100%">
        <th scope>Id Jabatan</th>
        <th scope>Id Status</th>
        <th scope>Hak Akses</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($queryBuilder as $d)
      <tr>
        <td>{{ $d->idjabatan}}</td>
        <td>{{ $d->idstatus }}</td>
        <td>{{ $d->hakAkses }}</td>
        <td class="text-right">
          <div class="dropdown">
            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              
            </div>
          </div>
        </td>

        @endforeach
    </tbody>

  </table>
</div>
</div>

</div>
</div></div>
@endsection