@extends('layouts.master')

@section('pagetitle','Edit Tags')

@push('css')

@endpush

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
	    <div class="panel panel-primary">
				<div class="panel-heading">EditTag</div>
				<div class="panel-body">
					<form role="form" action="{{ route('admin.tags.update',$tag->id) }}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="box-body">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" value="{{ $tag->name }}" class="form-control" name="name" id="name" placeholder="Enter Name">
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="status" id="status" {{ $tag->status==1?'checked':'' }}> Publish
								</label>
							</div>
						</div>
						<!-- /.box-body -->

						<div class="box-footer">
							<button type="submit" class="btn btn-success btn-sm">Update</button>
							<a href="{{ route('admin.tags.index') }}" class="btn btn-warning btn-sm">Back</a>
						</div>
					</form>
        </div>
			</div>
		</div>
	</div>
@endsection

@push('js')

@endpush
