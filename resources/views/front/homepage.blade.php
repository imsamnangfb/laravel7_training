@extends('layouts.front_layout')

@section('pagetitle','Home Page')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="{{ asset('frontend/front-page-category/css/styles.css')}}" rel="stylesheet">
    <link href="{{ asset('frontend/front-page-category/css/responsive.css')}}" rel="stylesheet">
    <link href="{{ asset('frontend/common-css/swiper.css') }}" rel="stylesheet">
@endpush

@push('banner')
    @include('front.includes.slider')
@endpush

@section('content')

  <div class="row">
		@foreach ($posts as $row)
			<div class="col-lg-4 col-md-6">
					<div class="card h-100">
							<div class="single-post post-style-1">
									<div class="blog-image"><img src="{{ asset('uploads/post/'.$row->image)}}" alt="Blog Image"></div>
									<a class="avatar" href="{{ route('post.detail',$row->id) }}"><img src="{{ asset('uploads/user/'.$row->user->image)}}" alt="Profile Image"></a>
									<div class="blog-info">
											<h4 class="title">
												<a href="{{ route('post.detail',$row->id) }}">
													<b>{{ $row->title }}</b>
												</a>
											</h4>
											<ul class="post-footer">
												@guest
													<li>
														<a href="javascript:void(0);" onclick="toastr.info('To add favorite list. ' +
														'You need to login first.','Info',{
																	closeButton:true,
																	progressBar:true
															})">
														<i class="ion-heart"></i>0
														</a>
													</li>
												@else
													<a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{$row->id}}').submit();"
														class="{{!Auth::user()->favorite_posts->where('pivot.post_id',$row->id)->count() ==0 ? 'favorite_posts':''}}">
														<i class="ion-heart"></i>
														{{$row->favorite_to_users->count()}}
													</a>
													<form id="favorite-form-{{$row->id}}" method="POST"
														action="{{route('favorite.save',$row->id)}}" style="display: none;">
														{{ csrf_field() }}
													</form>
												@endguest
												<li><a href="#"><i class="ion-chatbubble"></i>6</a></li>
												<li><a href="#"><i class="ion-eye"></i>{{ $row->view_count }}</a></li>
											</ul>

									</div><!-- blog-info -->
							</div><!-- single-post -->
					</div><!-- card -->
			</div><!-- col-lg-4 col-md-6 -->
		@endforeach

  </div><!-- row -->
  {{ $posts->render() }}
    <a class="load-more-btn" href="#"><b>LOAD MORE</b></a>
    @endsection
    
    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	{!! Toastr::message() !!}
    <script src="{{ asset('frontend/common-js/swiper.js') }}"></script>
@endpush


{{-- @guest
<a href="javascript:void(0);" onclick="toastr.info('To add favorite list. ' +
    'You need to login first.','Info',{
          closeButton:true,
          progressBar:true
      })">
<i class="ion-heart"></i>{{$post->favorite_to_users->count()}}</a>
@else
<a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{$post->id}}').submit();"
    class="{{!Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count() ==0 ? 'favorite_posts':''}}">
    <i class="ion-heart"></i>
    {{$post->favorite_to_users->count()}}</a>
<form id="favorite-form-{{$post->id}}" method="POST"
      action="{{route('post.favorite',$post->id)}}" style="display: none;">
    @csrf
</form>
@endguest --}}
