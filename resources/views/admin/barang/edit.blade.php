@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
  <div class="row">
      <div class="col-xl-12 mb-5 mb-xl-0">

<div class="card bg-secondary shadow">
	<div class="card-header bg-white border-0">
		<div class="row align-items-center">
			<h3 class="mb-0">Edit Barang</h3>
		</div>
	</div>
	<form enctype="multipart/form-data" role="form" method="POST" action="{{route('barang.update',$data->idbarang)}}">
		@csrf
		@method("PUT")
		<h6 class="heading-small text-muted mb-4"> &nbsp Ubah Informasi Barang</h6>

		<div class="pl-lg-4">
			<div class="form-group">
				<label for="exampleInputEmail1">Nama Barang</label>
				<input type="text" name="txtNama" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" value="{{$data->nama}}">
			</div>
			<!-- category id-->
			<div class="form-group">
				<label>Nama Kategori</label>
				<br>
				<select class="form-control" name="comboKat">
					@foreach($cat as $c)
					
					<option value="{{$c->idkategori}}" @if($c->idkategori == $data->kategori) selected @endif>{{$c->nama}}</option>
					@endforeach
				</select>
			</div>


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
</div></div>


@endsection