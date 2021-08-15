@extends('layouts.app')

@section('content')


<div class="card bg-secondary shadow">
	<div class="card-header bg-white border-0">
		<div class="row align-items-center">
			<h3 class="mb-0">Status Baru</h3>
		</div>
	</div>
	<form enctype="multipart/form-data" role="form" method="POST" action="{{route('status.store')}}">
		@csrf
		<h6 class="heading-small text-muted mb-4"> &nbsp Informasi Status</h6>

		<div class="pl-lg-4">
			<div class="form-group">
				<label for="exampleInputEmail1">Nama Status</label>
				<input type="text" name="txtName" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" style="width:600px;">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Kategori</label>
				<input type="text" name="txtKat" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" style="width:600px;">
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