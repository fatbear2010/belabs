@extends('layouts.app')

@section('content')

@include('layouts.headers.cards')

<div class="card bg-secondary shadow">
	<div class="card-header bg-white border-0">
		<div class="row align-items-center">
			<h3 class="mb-0">Perbaikan Baru</h3>
		</div>
	</div>
	<form enctype="multipart/form-data" role="form" method="POST" action="{{route('perbaikan.store')}}">
		@csrf
		<h6 class="heading-small text-muted mb-4"> &nbsp Informasi Perbaikan</h6>

		<div class="pl-lg-4">
			<div class="form-group">
				<label for="exampleInputEmail1">ID Perbaikan</label>
				<input type="text" name="txtID" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Mulai Perbaikan</label>
				<input type="date" name="txtMulai" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Selesai Perbaikan</label>
				<input type="date" name="txtSelesai" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Keterangan</label>
				<input type="text" name="txtKet" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text">
			</div>
			<div class="form-group">
				<label>ID Barang Detail</label>
				<br>
				<select class="form-control" name="comboKat">
					@foreach($bDetail as $p)
					<option value="{{$p->idbarangDetail}}">{{$p->idbarangDetail}}</option>
					@endforeach
				</select>
			</div>

			<div class="text-center">
				<button type="submit" class="btn btn-primary">Submit</button>
				<button onClick="history.back()" type="button" class="btn btn-default">Cancel</button>
			</div>

		</div>
	</form>
	<div class="portlet-body form">

	</div>
</div>


@endsection