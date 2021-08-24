@extends('layouts.app')

@section('content')

@include('layouts.headers.cards')

<div class="container-fluid mt--7">
	<div class="row">
		<div class="col-xl-12 mb-5 mb-xl-0">


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

						<div class="form-group">
							<label for="exampleInputEmail1">Hak Akses</label>
							@foreach($queryBuilder as $j)
							<div class="custom-control custom-checkbox">
								<input name="check_{{$j->idjabatan}}"type="checkbox" class="custom-control-input" id="check_{{$j->idjabatan}}">
								<label class="custom-control-label" for="check_{{$j->idjabatan}}">{{$j->nama}}</label>
							</div>
							@endforeach


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
	</div>
</div>

@endsection