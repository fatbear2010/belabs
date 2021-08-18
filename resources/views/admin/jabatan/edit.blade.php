@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="card bg-secondary shadow">
	<div class="card-header bg-white border-0">
		<div class="row align-items-center">
			<h3 class="mb-0">Edit Jabatan</h3>
		</div>
	</div>
	<form enctype="multipart/form-data" role="form" method="POST" action="{{route('jabatan.update',$data->idjabatan)}}">
		@csrf
		@method("PUT")
		<h6 class="heading-small text-muted mb-4"> &nbsp Ubah Informasi Jabatan</h6>

		<div class="pl-lg-4">
			<div class="form-group">
				<label for="exampleInputEmail1">Nama Jabatan</label>
				<input type="text" name="txtName" class="form-control form-control-alternative" value="{{$data->nama}}">
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