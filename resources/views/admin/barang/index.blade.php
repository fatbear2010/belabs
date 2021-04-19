@extends('layouts.app')

@section('content')   

@include('layouts.headers.cards')
   
    <div class="page-toolbar" style ="font-size:large ; text-align:center">
        	
            INDEX ADMIN BARANG  
            <br><a href="{{route('barang.create')}}">+ NewBarang</a>
           
<div class="container">
  <h2>Table Barang</h2>
  <p> Ini adalah barang yang bisa dipesan</p>
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nama Barang</th>
        <th>ID Kategori</th>
      </tr>
    </thead>
    <tbody>
    @foreach($queryBuilder as $d)
      <tr>
        <td>{{ $d->idbarang }}</td>
        <td>{{ $d->nama }}</td>
        <td>{{ $d->kategori }}</td>
        <td><a href="{{route('barang.edit',$d->idbarang)}}" class= 'btn btn-xs btn-info'>edit</a>

<form method='Post' action="{{route('barang.destroy',$d->idbarang)}}">
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