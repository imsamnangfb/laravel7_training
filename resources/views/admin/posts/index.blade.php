@extends('layouts.master')

@section('pagetitle','Post List')

@push('css')
  <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">List Posts</h3>
					<span><a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm pull-right">Create Post</a></span>
        </div>
				{{-- @if (Session::has('success'))
						<div class="alert alert-success alert-dismissible">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong> {{ Session::get('success') }}
						</div>
				@endif --}}
				<!-- /.box-header -->
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>
                                <th>Title</th>
                                <th>Post By</th>
								<th>Is Approved</th>
								{{-- <th>Body</th> --}}
								<th>Category</th>
								{{-- <th>Tag</th> --}}
								<th>Photo</th>
								<th>Status</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($posts as $key => $row)
								<tr>
									<td>{{ ++$key }}</td>
                                    <td>{{ Str::limit($row->title, 15,'...') }}</td>
                                    <td>{{ $row->user->name }}</td>
									<td>
											@if ($row->is_approved==0)
												<label for="is_approve" class="label label-danger">Pending</label>
											@else
												<label for="is_approve" class="label label-success">Approved</label>
											@endif
									</td>
									{{-- <td>{!! Str::limit( $row->body, 100, '...') !!}</td> --}}
									<td>
										@foreach ($row->categories as $cat)
                                             <label for="" class="label label-info">{{ $cat->name }}</label>
										@endforeach
									</td>
									{{-- <td>
										@foreach ($row->tags as $tag)
											<label for="tag" class="label label-primary">{{ $tag->name }}</label>
										@endforeach
									</td> --}}
									<td>
										<img src="{{ asset('uploads/post/'.$row->image) }}" alt="{{ $row->name }}" width="40px" height="40px;">
									</td>
									<td>
										@if ($row->status==1)
											<label class="lable label-success">&nbsp;&nbsp;Active&nbsp;&nbsp;</label>
										@else
											<label class="lable label-danger">&nbsp;&nbsp;DisActive&nbsp;&nbsp;</label>
										@endif
									</td>
									<td>{{ date("d-M-Y", strtotime($row->created_at)) }}</td>
									<td>
										<a href="{{ route('admin.posts.show',$row->id) }}" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
										<a href="{{ route('admin.posts.edit',$row->id) }}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
										<a href="javascript:deleteObject({{ $row->id }})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
										<form id="frmDeletePost-{{ $row->id }}" style="display: none" action="{{ route('admin.posts.destroy',$row->id) }}" role="form" method="POST" enctype="multipart/form-data">
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
		</div>
    </div>
    @include('sweetalert::alert')
@endsection

@push('js')
	<!-- DataTables -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.all.min.js"></script>
	<script src="{{ asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{ asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
	<script>
			$(function () {
				$('#example1').DataTable()
				$('#example2').DataTable({
					'paging'      : true,
					'lengthChange': false,
					'searching'   : true,
					'ordering'    : true,
					'info'        : true,
					'autoWidth'   : false
				})
			})
	</script>
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

