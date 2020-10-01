
@extends('layouts.master')

@section('pagetitle','Create Tags')

@push('css')

@endpush

@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
	    <div class="panel panel-primary">
				<div class="panel-heading">Delete Tag</div>
				<div class="panel-body">
					<form role="form" action="{{ route('admin.tags.destroy',$id) }}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<div class="box-body">
							<center><h3 style="color: red;">Are you sure, you want to Delete this?</h3></center>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<div class="col-md-6 col-md-offset-3">
								<button type="submit" class="btn btn-primary btn-sm pull-left">Yes</button>
								<a href="{{ route('admin.tags.index') }}" class="btn btn-warning btn-sm pull-right">Cancel</a>
							</div>
						</div>
					</form>
        </div>
			</div>
		</div>
	</div>
@endsection

@push('js')

@endpush
