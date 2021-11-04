@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--7">
  <div class="row">
      <div class="col-xl-12 mb-5 mb-xl-0">

<div class="card-header border-0">
  <div class="row align-items-center">
    <div class="col-8">
      <h3 class="mb-0">USER</h3>
    </div>
    <div class="col-4 text-right">
      <a href="{{route('users.create')}}" class="btn btn-warning">Tambah USER</a>
    </div>
  </div>
</div>

<div class="col-12">
</div>

<div class="table-responsive">
  <table class="table align-items-center table-flush" ;">
    <thead class="thead-light">
      <tr style="width:100%">
        <th scope>NRP/NPK</th>
        <th scope>Nama</th>
        <th scope>Status</th>
        <th scope>Email</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($queryBuilder as $d)
      <tr>
        <td>{{ $d->nrpnpk}}</td>
        <td>{{ $d->nama }}</td>
        <td>{{ $d->status }}</td>
        <td>{{ $d->email }}</td>

        <td class="text-right">
          <div class="dropdown">
            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <a class="dropdown-item" href="{{route('users.edit',$d->nrpnpk)}}">Edit</a>
              
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