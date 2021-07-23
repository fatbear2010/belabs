@extends('layouts.app')

@section('content')   

    @include('layouts.headers.cards')
   
    <div class="page-toolbar" style ="font-size:large ; text-align:center">
        	
            INDEX ADMIN PERBAIKAN  
            <br><a href="{{route('perbaikan.create')}}">+ NewPerbaikan</a>
<div class="container">
  <h2>Table Perbaikan</h2>
  <p> Ini adalah perbaikan dari barang</p>
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Mulai Perbaikan</th>
        <th>Selesai Perbaikan</th>
        <th>Keterangan</th>
        <th>ID Barang</th>


      </tr>
    </thead>
    <tbody>
    @foreach($queryBuilder as $d)
      <tr>
        <td>{{ $d->idperbaikan }}</td>
        <td>{{ $d->mulai }}</td>
        <td>{{ $d->selesai }}</td>
        <td>{{ $d->keterangan }}</td>
        <td>{{ $d->barang }}</td>

        <td><a href="{{route('perbaikan.edit',$d->idperbaikan)}}" class= 'btn btn-xs btn-info'>edit</a>

        
<form method='Post' action="{{route('perbaikan.destroy',$d->idperbaikan)}}">
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