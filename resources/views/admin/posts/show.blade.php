@extends('layouts.master')
@section('pagetitle','Post Lists')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css">
<link rel="stylesheet" href="{{ asset('backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if($post->is_approved == false)
				<a href="{{ route('admin.posts.pending') }}" class="btn btn-danger waves-effect">BACK</a>
				{{-- <button type="button" class="btn btn-success waves-effect pull-right" onclick="approvePost({{ $post->id }})">
						<i class="fa fa-eye"></i>
						<span>Approve</span>
				</button> --}}
				<a href="javascript:approvePost({{ $post->id }})" class="btn btn-success waves-effect pull-right">	<i class="fa fa-eye"></i>
					<span>Approve</span></a>
				<form method="post" action="{{ route('admin.posts.approve',$post->id) }}" id="approval-form-{{ $post->id }}" style="display: none">
					{{ csrf_field() }}
					{{ method_field("PUT") }}
				</form>
			@else
				<a href="{{ route('admin.posts.index') }}" class="btn btn-danger waves-effect">BACK</a>
				<button type="button" class="btn btn-success pull-right" disabled>
					<i class="fa fa-eye"></i>
					<span>Approved</span>
				</button>
			@endif
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3>{{ $post->title }}</h3>
					<p>Post by : {{ $post->user->name }}</p>
				</div>
				<div class="panel-body">
					<div class="box-body">
						{!! $post->body !!}
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">Categories</div>
				<div class="panel-body">
					<div class="box-body">
						@foreach ($post->categories as $cat)
							<label for="categories" class="label label-info">{{ $cat->name }}</label>
						@endforeach
					</div>
				</div>
			</div>
			<div class="panel panel-warning">
				<div class="panel-heading">Tags</div>
				<div class="panel-body">
					<div class="box-body">
						@foreach ($post->tags as $tag)
							<label for="categories" class="label label-success">{{ $tag->name }}</label>
						@endforeach
					</div>
				</div>
			</div>
			<div class="panel panel-primary">
				<div class="panel-heading">Feature Image</div>
				<div class="panel-body">
					<div class="box-body">
						<a href="{{ asset('uploads/post/'.$post->image) }}">
							<img src="{{ asset('uploads/post/'.$post->image) }}" class="img-responsive thumbnail"">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
	$(document).ready(function(){
		$('#postlist').DataTable();
	});

	function approvePost(id) {
		Swal.fire({
			title: 'Are you sure?',
			text: "You went to approve this post ",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Approve it!'
		}).then((result) => {
			if (result.value) {
				document.getElementById('approval-form-'+id).submit();
			}
		})
	}
</script>
@endpush
