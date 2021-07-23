@extends('layouts.app')

@section('content')   

    @include('layouts.headers.cards')
   
    <div class="page-toolbar" style ="font-size:large ; text-align:center">
        	
            INDEX ADMIN KATEGORI  
            <br><a href="{{route('jabatan.create')}}">+ NewJabatan</a>
<div class="container">
  <h2>Table Jabatan</h2>
  <p> Ini adalah Jabatan yang ada di sistem ini</p>
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nama Jabatan</th>
      </tr>
    </thead>
    <tbody>
    @foreach($queryBuilder as $d)
      <tr>
        <td>{{ $d->idjabatan }}</td>
        <td>{{ $d->nama }}</td>
        <td><a href="{{route('jabatan.edit',$d->idjabatan)}}" class= 'btn btn-xs btn-info'>edit</a>

<form method='Post' action="{{route('jabatan.destroy',$d->idjabatan)}}">
@csrf
@method('DELETE')
<input type="submit" value="delete" class='btn btn-danger btn-xs'
onclick="if(!confirm('Yakin Hapus??'))return false;"/>
</form>
</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
      </div>
  
@endsection