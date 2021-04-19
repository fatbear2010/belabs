
@extends('layouts.app')

@section('content')   

    @include('layouts.headers.cards')
   
    <div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-reorder"></i> New Product
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
							role="form" method="POST" action="{{route('barang.store')}}">
                            @csrf
								<div class="form-body">
                                <div class="form-group">
										<label for="exampleInputEmail1">ID Produk</label>
										<input type="text" name="txtID" class="form-control" id="exampleInputEmail1" placeholder="Enter text">
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">Nama Produk</label>
										<input type="text" name="txtNama" class="form-control" id="exampleInputEmail1" placeholder="Enter text">
									</div>
                                    
									<!-- category id-->
                                    <div class="form-group">
										<label>Kategori</label>
                                        <br>
										<select class="form-control" name="comboKat">
											@foreach($cat as $c)
                                            <option value="{{$c->idkategori}}">{{$c->nama}}</option>
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