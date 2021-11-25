@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
	<div class="row">
		<div class="col-xl-12 mb-5 mb-xl-0">


			<div class="card bg-secondary shadow">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<h3 class="mb-0">Lab Baru</h3>
					</div>
				</div>
				<form enctype="multipart/form-data" role="form" method="POST" action="{{route('lab.store')}}">
					@csrf
					<h6 class="heading-small text-muted mb-4"> &nbsp Informasi Lab</h6>

					<div class="pl-lg-4">
						<div class="form-group">
							<label for="exampleInputEmail1">ID Lab</label>
							<input type="text" name="txtID" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" style="width:600px;">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Nama Lab</label>
							<input type="text" name="txtName" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" style="width:600px;">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Lokasi</label>
							<input type="text" name="txtLokasi" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" style="width:600px;">
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
								<option value="{{$f->idfakultas}}">{{$f->namafakultas}}</option>
								@endforeach
							</select>
							<!-- <input type="text" name="txtFakultas" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" style="width:600px;"> -->
						</div>
						<div class="form-group">
							<label>Laboran</label>
							<br>
							<select class="form-control multiple-laboran" name="comboLab" id="comboLab">
								@foreach($user as $c)
								<option value="{{$c->nrpnpk}}">{{$c->nama}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Keterangan</label>
							<input type="text" name="txtket" class="form-control form-control-alternative" id="txtket" placeholder="Enter text" style="width:600px;">
						</div>
						<button onclick="inputlaboran()" type="button" class="btn btn-warning">Tambah Laboran</button>
						<table class="table align-items-center table-flush">
							<thead class="thead-light">
								<tr>
									<th scope="col">ID</th>
									<th scope="col">Nama Laboran</th>
									<th scope="col">Keterangan</th>

									<th scope="col"></th>
								</tr>
							</thead>
							<tbody id="datalaboran">

							</tbody>
						</table>


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

<script>
	var lab = [];

	function inputlaboran() {
		
		var laboran_id = $('#comboLab').val();
		var keterangan = $('#txtket').val();
		var tersedia = false;
		console.log(laboran_id);

		for (let i = 0; i < lab.length; i++) {
			
			if (lab[i][0] == laboran_id) {
				lab[i][1] = keterangan
				tersedia = true;
				
			}
		}

		if (!tersedia) {
			lab.push([laboran_id, keterangan]);
		}

		$.ajax({
			type: 'POST',
			url: '{{route("lab.showlaboran")}}',
			data: {
				'_token': '<?php echo csrf_token() ?>',
				'lab': lab
			},
			success: function(data) {	
				$('#datalaboran').html(data.msg);
			}
			
		});
	}

	function removelaboran($id) {
		for (let i = 0; i < lab.length; i++) {
			if (lab[i][0] == $id) {
				lab.splice(i, 1);
				if (lab.length > 0) {
					$.ajax({
						type: 'POST',
						url: '{{route("lab.showlaboran")}}',
						data: {
							'_token': '<?php echo csrf_token() ?>',
							'lab': lab
						},
						success: function(data) {
							$('#datalaboran').html(data.msg);
						}
					});
				} else {
					$('#datalaboran').html('');
				}
			}
		}
	}
	$(document).ready(function() {
		$('.multiple-laboran').select2();
	});
</script>
@endsection