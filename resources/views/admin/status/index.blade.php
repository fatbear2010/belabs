@extends('layouts.app')

@section('content')

<div class="card-header border-0">
  <div class="row align-items-center">
    <div class="col-8">
      <h3 class="mb-0">STATUS</h3>
    </div>
    <div class="col-4 text-right">
      <a href="{{route('status.create')}}" class="btn btn-sm btn-primary">Tambah STATUS</a>
    </div>
  </div>
</div>

<div class="col-12">
</div>

<div class="table-responsive">
  <table class="table align-items-center table-flush" ;">
    <thead class="thead-light">
      <tr style="width:100%">
        <th scope>ID</th>
        <th scope>Nama Status</th>
        <th scope>Kategori</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($queryBuilder as $d)
      <tr>
        <td>{{ $d->idstatus }}</td>
        <td>{{ $d->nama }}</td>
        <td>{{ $d->kategori }}</td>
        <td class="text-right">
          <div class="dropdown">
            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <a class="dropdown-item" href="{{route('status.edit',$d->idstatus)}}">Edit</a>
              <form method='Post' action="{{route('status.destroy',$d->idstatus)}}">
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


@endsection