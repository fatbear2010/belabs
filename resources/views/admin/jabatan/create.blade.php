@extends('layouts.app')

@section('content')   

    @include('layouts.headers.cards')
    
    <div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-reorder"></i>+New Jabatan
							</div>
							<div class="tools">
								<a href="" class="collapse"></a>
								<a href="#portlet-config" data-toggle="modal" class="config"></a>
								<a href="" class="reload"></a>
								<a href="" class="remove"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<form role="form" method="POST" action="{{route('jabatan.store')}}">
                            @csrf
								<div class="form-body">
									<div class="form-group">
										<label for="exampleInputEmail1">Nama Jabatan</label>
										<input type="text" name="txtName" class="form-control" id="exampleInputEmail1" placeholder="Enter text"  style ="width:600px;">
									</div>
									 
									
								<div class="form-actions">
									<button type="submit" class="btn btn-primary">Submit</button>
									<button onClick="history.back()" type="button" class="btn btn-default">Cancel</button>
								</div>
							</form>
						</div>
					</div>
                   


@endsection