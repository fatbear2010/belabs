@extends('layouts.app')

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
  <div class="row">
      <div class="col-xl-12 mb-5 mb-xl-0">

<div class="card bg-secondary shadow">
	<div class="card-header bg-white border-0">
		<div class="row align-items-center">
			<h3 class="mb-0">Barang Baru</h3>
		</div>
	</div>
	<div class="card-body">
		<form enctype="multipart/form-data" role="form" method="POST" action="{{route('barang.store')}}">
			@csrf
			<h6 class="heading-small text-muted mb-4"> &nbsp Informasi Barang</h6>

			<div class="pl-lg-4">
				<div class="form-group">
					<label for="form-control-label">ID Produk</label>
					<input type="text" name="txtID" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text">
				</div>

				<div class="form-group">
					<label for="form-control-label">Nama Produk</label>
					<input type="text" name="txtNama" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text">
				</div>
				<div class="form-group">
					<label>Kategori</label>
					<br>
					<select class="form-control" name="comboKat">
						@foreach($cat as $c)
						<option value="{{$c->idkategori}}">{{$c->nama}}</option>
						@endforeach
					</select>
				</div>


			</div>

			<hr class="my-4">
			<h6 class="heading-small text-muted mb-4"> &nbsp Informasi Barang Detil</h6>
			<input type="number" class="form-control" id="detailbrg" placeholder="Jumlah Detail Barang" min=1 required>
			


			<div id="loop">

			</div>
			<div class="text-center">
				<button type="submit" class="btn btn-warning">Submit</button>
				<button onClick="history.back()" type="button" class="btn btn-outline-warning">Cancel</button>
			</div>
		</form>
	</div>
	<div class="portlet-body form">

	</div>
</div>
</div>
</div>
</div>

<script>
	var oldNumber = 0;

	$("#detailbrg").bind('keyup mouseup', function() {
		jumlah = $('#detailbrg').val();

		if(jumlah==0)
		{
			$("#loop").html("");
		} 
		else if (jumlah < oldNumber) {
			console.log("masok") 
			for (var i = (oldNumber-1); i >= jumlah; i--) {
				$("#angka_" + i).remove();
			}

		}
		 
		else if(jumlah>=oldNumber) {
			
			
			for (var i = oldNumber; i < jumlah; i++) {
				var loop = `<div class="pl-lg-4" id="angka_` + i + `">
				
			<div class="form-group">
				<label for="form-control-label"><strong>ID Barang Detail</strong></label>
				<input type="text" name="txtIDDetail[]" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" required>
			</div>

			<div class="form-group">
				<label for="form-control-label">Merk</label>
				<input type="text" name="txtMerk[]" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" required>
			</div>
			<div class="form-group">
				<label for="form-control-label">Kondisi</label>
				<input type="text" name="txtKondisi[]" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" required>
			</div>
			<div class="form-group">
				<label for="form-control-label">Perbaikan</label>
				<input type="text" name="txtPerbaikan[]" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" required>
			</div>
			<div class="form-group">
				<label for="form-control-label">Status</label>
				<input type="text" name="txtStatus[]" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" required>
			</div>
			<div class="form-group">
				<label>Lab</label>
				<br>
				<select class="form-control" name="comboLab[]" value = "{{$lab[0]->idlab}}">
					@foreach($lab as $l)
					<option value="{{$l->idlab}}">{{$l->namaLab}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="form-control-label">Jumlah Pakai(kali)</label>
				<input type="text" name="txtJum1[]" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" required>
			</div>
			<div class="form-group">
				<label for="form-control-label">Durasi Pakai(...jam)</label>
				<input type="text" name="txtJum2[]" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" required>
			</div>
			<div class="form-group">
				<label for="form-control-label">Waktu Pakai (/hari)</label>
				<input type="text" name="txtWkt1[]" class="form-control form-control-alternative" id="exampleInputEmail1" placeholder="Enter text" required>
			</div>
			<div class="form-group">
				<label for="form-control-label">Gambar Barang</label>
				<input type="file" multiple name="filefoto_`+i+`[]" class="form-control form-control-alternative" id="exampleInputEmail1" required>
			</div>

			<hr class="my-4">
		</div>`;
				$('#loop').append(loop);
			}
		}
		oldNumber = jumlah;


	});
</script>


@endsection