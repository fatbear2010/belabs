@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--7">
	<div class="row">
		<div class="col-xl-12 mb-5 mb-xl-0">


			<div class="card bg-secondary shadow">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<h3 class="mb-0">Edit Status</h3>
					</div>
				</div>
				<form enctype="multipart/form-data" role="form" method="POST" action="{{route('users.update',$data->nrpnpk)}}">
					@csrf
					@method("PUT")
					<h6 class="heading-small text-muted mb-4"> &nbsp Ubah Informasi Status Jabatan</h6>

					<div class="pl-lg-4">

						<div class="form-group">
							
							<div class="form-group">
								<label for="form-control-label">NRP/NPK</label>
								<input type="text" name="txtNRP" class="form-control form-control-alternative" id="exampleInputEmail1" value="{{$data->nrpnpk}}">
							</div>
							<div class="form-group">
								<label for="form-control-label">Nama</label>
								<input type="text" name="txtNama" class="form-control form-control-alternative" id="exampleInputEmail1" value="{{$data->nama}}">
							</div>
							<div class="form-group">
								<label>Jabatan</label>
								<br>
								<select class="form-control" name="comboJabatan">
									@foreach($jabatan as $c)
									<option value="{{$c->idjabatan}}" @if($c->idjabatan == $data->jabatan) selected @endif>{{$c->nama}}</option>
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
	</div>
</div>

@endsection