@extends('layouts.master')
@section('pagetitle','Post List')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
@endpush

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form method="POST" action="{{ route('admin.upload.dropzone.store') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="dropzone dz-clickable" id="dropzone">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="post_id">Post ID</label>
						<select class="form-control" name="post_id" id="post_id">
							<option>Select Post</option>
							@foreach ($posts as $key =>$row)
								<option value="{{ $row->id }}">{{ $row->title }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="product_group">Post Group</label>
						<input type="text" class="form-control" name="product_group" id="product_group" aria-describedby="helpId" placeholder="" readonly>
					</div>
					<div class="dz-default dz-message">
						<span>Drop files here to upload</span>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>

	<script type="text/javascript">	
		Dropzone.options.dropzone =
		{
			maxFilesize: 12,
			renameFile: function (file) {
				  var d = Date.parse(new Date);
					var dt = new Date();
					var time = dt.getTime();
					return d +'-' + time + '-' + file.name;
			},
			acceptedFiles: ".jpeg,.jpg,.png,.gif,.bmp,.svg",
			addRemoveLinks: true,
			timeout: 50000,
			removedfile: function (file) {
				var name = file.upload.filename;
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
					},
					type: 'POST',
					url: '{{ route("admin.upload.dropzone.delete") }}',
					data: {filename: name},
					success: function (data) {
						console.log("File has been successfully removed!!");
					},
					error: function (e) {
						console.log(e);
					}
				});
				var fileRef;
				return (fileRef = file.previewElement) != null ?
				fileRef.parentNode.removeChild(file.previewElement) : void 0;
			},
			success: function (file, response) {
				console.log(response);
			},
			error: function (file, response) {
				return false;
			}
		};
	</script>
	<script type="text/javascript">
    $(document).ready(function(){
      $("#post_id").change(function(){
        $('#product_group').empty();
        var getSelected = $("#post_id").find("option:selected").text();
        $("#product_group").val(getSelected);
      });
    });
  </script>
@endpush
