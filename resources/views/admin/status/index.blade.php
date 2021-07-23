@extends('layouts.app')

@section('content')   

    @include('layouts.headers.cards')
   
    <div class="page-toolbar" style ="font-size:large ; text-align:center">
        	
            INDEX ADMIN STATUS  
            <br><a href="{{route('status.create')}}">+ NewStatus</a>
<div class="container">
  <h2>Table Status</h2>
  <p> Ini adalah status dari history pemesanan</p>
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nama Status</th>
        <th>Kategori</th>

      </tr>
    </thead>
    <tbody>
    @foreach($queryBuilder as $d)
      <tr>
        <td>{{ $d->idstatus }}</td>
        <td>{{ $d->nama }}</td>
        <td>{{ $d->kategori }}</td>

        <td><a href="{{route('status.edit',$d->idstatus)}}" class= 'btn btn-xs btn-info'>edit</a>

<form method='Post' action="{{route('status.destroy',$d->idstatus)}}">
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