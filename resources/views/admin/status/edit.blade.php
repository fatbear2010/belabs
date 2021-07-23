@extends('layouts.app')

@section('content')   

    @include('layouts.headers.cards')
    
<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-reorder"></i> Edit Category
							</div>
							<div class="tools">
								<a href="" class="collapse"></a>
								<a href="#portlet-config" data-toggle="modal" class="config"></a>
								<a href="" class="reload"></a>
								<a href="" class="remove"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<form role="form" method="POST" action="{{route('status.update',$data->idstatus)}}">
                            @csrf
                            @method("PUT")
								<div class="form-body">
									<div class="form-group">
										<label for="exampleInputEmail1">Name</label>
										<input type="text" name="txtName" value="{{$data->nama}}">
									</div>
                                    <div class="form-group">
										<label for="exampleInputEmail1">Kategori</label>
										<input type="text" name="txtKat" value="{{$data->kategori}}">
									</div>
									
									
								<div class="form-actions">
									<button type="submit" class="btn btn-primary">Submit</button>
									<button onClick="history.back()" type="button" class="btn btn-default">Cancel</button>
								</div>
							</form>
						</div>
					</div>

@endsection