
@extends('layouts.app')

@section('content')   

    @include('layouts.headers.cards')
   
    <div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-reorder"></i> Edit Perbaikan
							</div>
							<div class="tools">
								<a href="" class="collapse"></a>
								<a href="#portlet-config" data-toggle="modal" class="config"></a>
								<a href="" class="reload"></a>
								<a href="" class="remove"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<form enctype="multipart/form-data" 
							role="form" method="POST" action="{{route('perbaikan.update',$data->idperbaikan)}}">
                            @csrf
                            @method("PUT")

								<div class="form-body">
                                <div class="form-group">
										<label for="exampleInputEmail1">Mulai Perbaikan</label>
										<input type="date" name="txtMulai" class="form-control" id="exampleInputEmail1" placeholder="Enter text"value="{{$data->mulai}}">
									</div>
                                    <div class="form-group">
										<label for="exampleInputEmail1">Selesai Perbaikan</label>
										<input type="date" name="txtSelesai" class="form-control" id="exampleInputEmail1" placeholder="Enter text"value="{{$data->selesai}}">
									</div>
                                    <div class="form-group">
										<label for="exampleInputEmail1">Keterangan</label>
										<input type="text" name="txtKet" class="form-control" id="exampleInputEmail1" placeholder="Enter text"value="{{$data->keterangan}}" >
									</div>
                                    
    
                                    
									<!-- category id-->
                                    <div class="form-group">
										<label>ID Barang</label>
                                        <br>
										<select class="form-control" name="comboKat">
											@foreach($bar as $d)
                                            <option value="{{$d->idbarangDetail}}">{{$d->idbarangDetail}}</option>
                                            @endforeach
										</select>
									</div>

                                    <!-- <div class="form-group">
                  					<label>Foto Produk</label>
                  					<input type="file" class="form-control"
                   						  id ='logo' name='logo'>
               						</div> -->
                                       
								<div class="form-actions">
									<button type="submit" class="btn btn-primary">Submit</button>
									<button onClick="history.back()" type="button" class="btn btn-default">Cancel</button>
								</div>
							</form>
						</div>
					</div>
  
@endsection