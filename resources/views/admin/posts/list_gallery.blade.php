@extends('layouts.master')

@section('pagetitle','Galleries List')

@push('css')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css">
@endpush

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				@foreach ($galleries as $row)
					<div class="col-md-2">
						<div class="panel panel-primary">
							<div class="panel-heading">{{ Str::limit($row->post->title,15) }}</div>
							<div class="panel-body">
								<img src="{{ asset('uploads/post/galleries/'.$row->gallery_image) }}" width="125px;" height="140px" alt="">
							</div>
							<div class="panel-footer">
								<a href="{{ asset('uploads/post/galleries/'.$row->gallery_image) }}" class="btn btn-info btn-sm">View</a>
								<button class="btn btn-danger btn-sm" onclick="deleteObject({{ $row->id }})">Delete</button>
								<form id="frmDeletePost-{{ $row->id }}" style="display: none" action="{{ route('admin.posts.gallery.destroy',$row->id) }}" role="form" method="POST" enctype="multipart/form-data">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}
								</form>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">
	function deleteObject(id){
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {
				document.getElementById('frmDeletePost-'+id).submit();
				Swal.fire(
					'Deleted!',
					'Your file has been deleted.',
					'success'
				)
			}
		})
	}
</script>
@endpush
