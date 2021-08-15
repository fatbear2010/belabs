@extends('layouts.app')

@section('content')


<div class="card bg-secondary shadow">
	<div class="card-header bg-white border-0">
		<div class="row align-items-center">
			<h3 class="mb-0">Edit Status</h3>
		</div>
	</div>
	<form enctype="multipart/form-data" role="form" method="POST" action="{{route('status.update',$data->idstatus)}}">
		@csrf
		@method("PUT")
		<h6 class="heading-small text-muted mb-4"> &nbsp Ubah Informasi Perbaikan</h6>

		<div class="pl-lg-4">
			
		<div class="form-group">
					<label for="exampleInputEmail1">Name</label>
					<input type="text" name="txtName" class="form-control form-control-alternative" value="{{$data->nama}}">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Kategori</label>
					<input type="text" name="txtKat" class="form-control form-control-alternative" value="{{$data->kategori}}">
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