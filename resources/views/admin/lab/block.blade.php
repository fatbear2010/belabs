@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">


            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">Tambah Waktu Block</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" role="form" method="POST" action="{{route('lab.storeblock')}}">
                    @csrf
                    <h6 class="heading-small text-muted mb-4"> &nbsp Tambah Waktu Penggunaan</h6>

                    <div class="pl-lg-4">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input class="form-control form-control-alternative" type="date" name="dateTanggal" id= "dateTanggal" min="{{ now()->toDateString('Y-m-d') }}" onkeydown="return false">
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
                        <div class="form-group">
                            <label>Keterangan</label>
                            <br>
                            <input class="form-control form-control-alternative" type="text" name="txtketerangan" id= "txtketerangan">
                        </div>
                    </div>
						<button onclick="inputblock()" type="button" class="btn btn-warning">Tambah Sesi Penggunaan</button>
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
	
	function inputblock () {
		var tanggal= $('#dateTanggal').val();
		var IDsesi = $('#comboMulai').val();
		var mulai = $('#comboMulai :selected').text();
		var selesai = $('#comboSelesai :selected').text();
		var keterangan = $('#txtketerangan').val();
		//var haritxt = $('#comboHari :selected').text();
        var idlab = "<?php echo $data->idlab?>"
		var tersedia = false;
		//console.log(idBarangdetail);

		for (let i = 0; i < sesi.length; i++) {
			
			if (sesi[i][0] == tanggal) {
				sesi[i][1] = IDsesi
				sesi[i][2] = mulai
				sesi[i][3] = selesai
				//sesi[i][4] = haritxt
				sesi[i][4] = idlab
				sesi[i][5] = keterangan
               
				tersedia = true;
				
			}
		}

		if (!tersedia) {
			sesi.push([tanggal,IDsesi,mulai, selesai,idlab,keterangan]);
		}

		$.ajax({
			type: 'POST',
			url: '{{route("lab.showblock")}}',
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
						url: '{{route("lab.showblock")}}',
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