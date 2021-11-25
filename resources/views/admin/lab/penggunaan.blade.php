@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">


            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">Tambah Waktu	</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" role="form" method="POST" action="{{route('lab.storewaktu')}}">
                    @csrf
                    <h6 class="heading-small text-muted mb-4"> &nbsp Tambah Waktu Penggunaan</h6>

                    <div class="pl-lg-4">
                        <div class="form-group">
                            <label>Hari</label>
                            <br>
                            <select class="form-control" name="comboHari" id="comboHari">

                                <option value="1">Senin</option>
                                <option value="2">Selasa</option>
                                <option value="3">Rabu</option>
                                <option value="4">Kamis</option>
                                <option value="5">Jumat</option>
                                <option value="6">Sabtu</option>
                                <option value="7">Minggu</option>


                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jam Mulai</label>
                            <br>
                            <select class="form-control" name="comboMulai" id="comboMulai">
                                @foreach($sesi as $s)
                                <option value="{{$s->idsesi}}">{{$s->mulai}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jam Selesai</label>
                            <br>
                            <select class="form-control" name="comboSelesai" id="comboSelesai">
                                @foreach($sesi as $s)
                                <option value="{{$s->idsesi}}">{{$s->selesai}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
						<button onclick="inputsesi()" type="button" class="btn btn-warning">Tambah Sesi Penggunaan</button>
                        <table class="table align-items-center table-flush">
							<thead class="thead-light">
								<tr>
									<th scope="col">Hari</th>
									<th scope="col">Jam Mulai</th>
									<th scope="col">Jam Selesai</th>

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
                </form>
                <div class="portlet-body form">

                </div>
            </div>

        </div>
    </div>
</div>

<script>
	var sesi = [];
	
	function inputsesi() {
		var hari= $('#comboHari').val();
		var IDsesi = $('#comboMulai').val();
		var mulai = $('#comboMulai :selected').text();
		var selesai = $('#comboSelesai :selected').text();
		var haritxt = $('#comboHari :selected').text();
		var idlab = "<?php echo $data->idlab?>"
		var tersedia = false;
		//console.log(idBarangdetail);

		for (let i = 0; i < sesi.length; i++) {
			
			if (sesi[i][0] == hari) {
				sesi[i][1] = IDsesi
				sesi[i][2] = mulai
				sesi[i][3] = selesai
				sesi[i][4] = haritxt
				sesi[i][5] = idlab

				tersedia = true;
				
			}
		}

		if (!tersedia) {
			sesi.push([hari,IDsesi,mulai, selesai,haritxt,idlab]);
		}

		$.ajax({
			type: 'POST',
			url: '{{route("lab.showsesi")}}',
			data: {
				'_token': '<?php echo csrf_token() ?>',
				'sesi': sesi
			},
			success: function(data) {	
				$('#datalaboran').html(data.msg);
			}
			
		});
	}

	function removeSesi($id) {
		for (let i = 0; i < sesi.length; i++) {
			if (sesi[i][1] == $id) {
				sesi.splice(i, 1);
				if (sesi.length > 0) {
					$.ajax({
						type: 'POST',
						url: '{{route("lab.showsesi")}}',
						data: {
							'_token': '<?php echo csrf_token() ?>',
							'sesi': sesi
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