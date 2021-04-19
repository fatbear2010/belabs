@extends('layouts.app')

@section('content')   

    @include('layouts.headers.cards')
   
    <div class="page-toolbar" style ="font-size:large ; text-align:center">
        	
            INDEX ADMIN KATEGORI  
            <br><a href="{{route('kategori.create')}}">+ NewCategory</a>
            <br> NANTI DIISI TABEL BLABLABLA
<div class="container">
  <h2>Table Kategori</h2>
  <p> Ini adalah kategori dari barang yang bisa dipesan</p>
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nama Kategori</th>
      </tr>
    </thead>
    <tbody>
    @foreach($queryBuilder as $d)
      <tr>
        <td>{{ $d->idkategori }}</td>
        <td>{{ $d->nama }}</td>
        <td><a href="{{route('kategori.edit',$d->idkategori)}}" class= 'btn btn-xs btn-info'>edit</a>

<form method='Post' action="{{route('kategori.destroy',$d->idkategori)}}">
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