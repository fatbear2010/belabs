@extends('layouts.app')

@section('content')

@include('layouts.headers.cards')
<div class="container-fluid mt--7">
  <div class="row">
      <div class="col-xl-12 mb-5 mb-xl-0">


<div class="card bg-secondary shadow">
	<div class="card-header bg-white border-0">
		<div class="row align-items-center">
			<h3 class="mb-0">Edit Perbaikan</h3>
		</div>
	</div>
	<form enctype="multipart/form-data" role="form" method="POST" action="{{route('perbaikan.update',$data->idperbaikan)}}">
		@csrf
		@method("PUT")
		<h6 class="heading-small text-muted mb-4"> &nbsp Ubah Informasi Perbaikan</h6>

		<div class="pl-lg-4">
			
			<div class="form-group">
				<label for="exampleInputEmail1">Mulai Perbaikan</label>
				<input type="date" name="txtMulai" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" value="{{$data->mulai}}">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Selesai Perbaikan</label>
				<input type="date" name="txtSelesai" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" value="{{$data->selesai}}">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Keterangan</label>
				<input type="text" name="txtKet" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" value="{{$data->keterangan}}">
			</div>
			<div class="form-group">
					<label>ID Barang</label>
					<br>
					<select class="form-control" name="comboKat">
						@foreach($bar as $d)
						<option value="{{$d->idbarangDetail}}">{{$d->idbarangDetail}}</option>
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