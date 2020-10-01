@extends('layouts.master')

@section('pagetitle','Create User')
    
@push('css')
	<link rel="stylesheet" href="{{ asset('backend/plugins/iCheck/all.css') }}">
@endpush

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
	    <div class="panel panel-primary">
				<div class="panel-heading">Add User Tag</div>
				<div class="panel-body">
					<form role="form" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}
						<div class="box-body">
							<div class="row">
								<div class="col-md-10">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="name">Name</label>
												<input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="name">UserName</label>
												<input type="text" class="form-control" name="username" id="username" placeholder="Enter Username">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="name">Phone</label>
												<input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="name">Email</label>
												<input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label for="name">Role Name</label>
												<select name="role_id" id="role_id" class="form-control">
														<option value="">Choose Role</option>
														@foreach ($roles as $row)																
															<option value="{{ $row->id }}">{{ $row->name }}</option>
														@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<label for="name">About</label>
												<input type="text" class="form-control" name="about" id="about" placeholder="Enter About">
											</div>
										</div>
										<div class="col-md-2">
											<label for="name"></label>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="status" id="status" checked>&nbsp;Publish
												</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="name">Password</label>
												<input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="name">Confirm</label>
												<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
											</div>
										</div>
									</div>									
								</div>
								<div class="col-md-2">
									<label for="">Profile Image</label>
									<img src="{{ asset('images/noimage.jpg') }}" alt="" 
											name="preview" id="preview" width="110px" height="120px">
									<input type="file" name="image" id="image" style="display: none">
									<br>
									<a href="javascript:changeProfile()" class="btn btn-success btn-xs" id="upload">Upload</a>
									<a href="javascript:removeImage()" class="btn btn-danger btn-xs" id="remove">Remove</a>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<div class="row">
								<div class="col-md-2 col-md-offset-5">
									<button type="submit" class="btn btn-primary btn-sm pull-left">Save</button>
									<a href="{{ route('admin.tags.index') }}" class="btn btn-warning btn-sm pull-right">Back</a>
								</div>
							</div>
						</div>
					</form>
        </div>
			</div>  		
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