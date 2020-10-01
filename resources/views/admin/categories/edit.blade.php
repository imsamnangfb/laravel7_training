@extends('layouts.master')

@section('pagetitle','Create Category')

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/plugins/iCheck/all.css') }}">
@endpush

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<form method="POST" action="{{route('admin.categories.update',$category->id) }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="panel panel-primary">
						<div class="panel-heading">Add New Category</div>
						<div class="panel-body">
							<div class="box-body">
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
											<label for="name">Category Title</label>
											<input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ $category->name }}">
										</div>
											<!-- checkbox -->
										<div class="form-group">
											<label>
												<input type="checkbox" id="status" class="status" name="status" {{ $category->status==1?'checked':'' }}>
												Publish
											</label>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group {{$errors->has('image') ? 'has-error' : ''}}">
											<br>
											<img id="preview" src="{{ asset('uploads/category/'.$category->image) }}" width="120px" height="100px"/><br/>
											<input type="file" id="image" style="display: none;"/ name="image">
											<br>
											<a href="javascript:changeProfile()" class="btn btn-success btn-xs">Upload</a> |
											<a href="javascript:removeImage()" data-id="{{ $category->id }}" id="remove" class="btn btn-danger btn-xs">Remove</a>
											@if ($errors->has('image'))
											<span class="help-block">
												<strong>{{ $errors->first('image') }}</strong>
											</span>
											@endif
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-4 col-md-offset-4">
										<input type="submit" value="Update" class="btn btn-success btn-sm">
										<a href="{{ route('admin.categories.list') }}" class="btn btn-warning btn-sm">Back</a>
									</div>
								</div>
							</div>
						</div>
					</div>
			</form>
		</div>
	</div>
@endsection

@push('js')
	<script src="{{ asset('backend/plugins/iCheck/icheck.min.js') }}"></script>
	<script>
		//iCheck for checkbox and radio inputs
		$('#status').iCheck({
		// $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%'
		});
    </script>
	<script>
		function changeProfile() {
			$('#image').click();
		}
		$('#image').change(function () {
			var imgPath = this.value;
			var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
			if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg") {
				$('#btn-remove').css('display','block');
				$('#btn-upload').text('Change');
				readURL(this);
			} else {
				alert("Please select image file (jpg, jpeg, png).")
			}
		});
		function readURL(input) {
			if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.readAsDataURL(input.files[0]);
					reader.onload = function (e) {
						$('#preview').attr('src', e.target.result);
					};
				$("#remove").val(0);
			}
		}
		function removeImage() {
			$('#preview').attr('src',"{{ asset('images/noimage.jpg') }}");
			$("#remove").val(1);
			// $('#btn-remove').css('display','none');
			// $('#btn-upload').text('Upload');
		}
	</script>
@endpush
