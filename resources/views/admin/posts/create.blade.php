@extends('layouts.master')
@section('pagetitle','Post List')

@push('css')
	<link rel="stylesheet" href="{{ asset('backend/bower_components/select2/dist/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/plugins/iCheck/all.css') }}">
	{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}"> --}}
@endpush

@section('content')
	<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-primary">
					<div class="panel-heading">Add New Post</div>
					<div class="panel-body">
						<div class="box-body">
							<div class="form-group">
								<label for="title">Post Title</label>
								<input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
							</div>

							<div class="form-group">
								<label for="exampleInputFile">Featured Image</label>
								<input type="file" id="image" name="image">
							</div>

							<div class="form-group">
								<label for="gallery_image">Gallery Image</label>
								<input type="file" id="gallery_image" name="gallery_image[]" multiple>
							</div>

							<!-- checkbox -->
							<div class="form-group">
								<label>
									<input type="checkbox" id="status" class="status" name="status" checked>
									Publish
								</label>
								{{-- <input type="hidden" id="status" class="status" value="0"> --}}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">Categories & Tags</div>
					<div class="panel-body">
						<div class="box-body">
				{{-- category --}}
							<div class="form-group">
								<label>Category</label>
								<select class="form-control select2" multiple="multiple" style="width: 100%;" name="category[]" data-placeholder="Choose Category" >
									@foreach ($categories as $cat)
											<option value="{{ $cat->id }}">{{ $cat->name }}</option>
									@endforeach
								</select>
							</div>
							{{-- tag --}}
							<div class="form-group">
								<label>Tags</label>
								<select class="form-control select2" multiple="multiple" data-placeholder="Choose Tags" style="width: 100%;" name="tag[]">
									@foreach ($tags as $tag)
										<option value="{{ $tag->id }}">{{ $tag->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-md-6">
								<input type="submit" value="Save" class="btn btn-success btn-block">
							</div>
							<div class="col-md-6">
								<a href="{{ route('admin.posts.index') }}" class="btn btn-warning btn-block">Back</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Body</div>
					<div class="panel-body">
						<textarea id="body" name="body" rows="10" cols="80">
								This is my textarea to be replaced with CKEditor.
						</textarea>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection

@push('js')
	<script src="{{ asset('backend/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
	<script src="{{ asset('backend/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/ckeditor/ckeditor.js') }}"></script>
    {{-- <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script> --}}
	{{-- <script src="{{ asset('backend/plugins/tinymce/tinymce.min.js') }}"></script> --}}
	<!-- iCheck 1.0.1 -->
    <script>
			//initialize for CKeditor
			CKEDITOR.replace('body',{
				extraPlugins: 'justify',
				filebrowserImageBrowseUrl: '/admin/laravel-filemanager?type=Images',
				filebrowserImageUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token=',
				filebrowserBrowseUrl: '/admin/laravel-filemanager?type=Files',
				filebrowserUploadUrl: '/admin/laravel-filemanager/upload?type=Files&_token='
			});
		</script>
	<script>
    //Initialize Select2 Elements
    $('.select2').select2();
    //iCheck for checkbox and radio inputs
    $('#status').iCheck({
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'iradio_square-red',
      increaseArea: '20%'
    });
	</script>

{{-- <script>
  var editor_config = {
    path_absolute : "/admin/",
    selector: "textarea#body",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);
</script> --}}
@endpush
