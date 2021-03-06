@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
	<div class="row">
		<div class="col-xl-12 mb-5 mb-xl-0">

			<div class="card bg-secondary shadow">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<h3 class="mb-0">Edit Lab</h3>
					</div>
				</div>
				<form enctype="multipart/form-data" role="form" method="POST" action="{{route('lab.update',$data->idlab)}}">
					@csrf
					@method("PUT")
					<h6 class="heading-small text-muted mb-4"> &nbsp Ubah Informasi Lab</h6>

					<div class="pl-lg-4">

						<div class="form-group">
							<label for="exampleInputEmail1">Nama Lab</label>
							<input type="text" name="txtName" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" style="width:600px;" value="{{$data->namaLab}}">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Lokasi</label>
							<input type="text" name="txtLokasi" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" style="width:600px;" value="{{$data->lokasi}}">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Kapasitas</label>
							<input type="text" name="txtkapasitas" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" style="width:600px;">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Fakultas</label>
							<br>
							<select class="form-control multiple-laboran" name="comboFak" id="comboFak">
								@foreach($fak as $f)
								<option value="{{$f->idfakultas}}" @if($f->idfakultas == $data->fakultas) selected @endif>{{$f->namafakultas}}</option>
								@endforeach
							</select>
							<!-- <input type="text" name="txtFakultas" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" style="width:600px;" value="{{$data->fakultas}}"> -->
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