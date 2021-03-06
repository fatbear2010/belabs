@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
  <div class="row">
      <div class="col-xl-12 mb-5 mb-xl-0">

<div class="card-header border-0">
  <div class="row align-items-center">
    <div class="col-12 col-md-8">
      <h3 class="mb-0">JABATAN</h3>
    </div>
    <div class="col-12 col-md-4 text-right">
      <a href="{{route('jabatan.create')}}" class="btn btn-warning">Tambah JABATAN</a>
    </div>
  </div>
</div>

<div class="col-12">
</div>

<div class="table-responsive">
  <table class="table align-items-center table-flush">
    <thead class="thead-light">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nama Jabatan</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($queryBuilder as $d)
      <tr>
        <td>{{ $d->idjabatan }}</td>
        <td>{{ $d->nama }}</td>
        <td class="text-right">
          <div class="dropdown">
            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <a class="dropdown-item" href="{{route('jabatan.edit',$d->idjabatan)}}">Edit</a>
              <form method='Post' action="{{route('jabatan.destroy',$d->idjabatan)}}">
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
</div></div>
  @endsection