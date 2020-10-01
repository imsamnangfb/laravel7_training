@extends('layouts.master')

@section('pagetitle','Create Role')
    
@push('css')
    
@endpush

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
	    <div class="panel panel-primary">
				<div class="panel-heading">Add New Role</div>
				<div class="panel-body">
					<form role="form" action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}
						<div class="box-body">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="status" id="status"> Publish
								</label>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-warning btn-sm">Back</a>
						</div>
					</form>
        </div>
			</div>  		
		</div>
	</div>
@endsection

@push('js')
    
@endpush