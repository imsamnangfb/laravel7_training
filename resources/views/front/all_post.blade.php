@extends('layouts.front_layout')

@section('pagetitle','All Posts')

@push('css')
    <link href="{{ asset('frontend/front-page-category/css/styles.css')}}" rel="stylesheet">
    <link href="{{ asset('frontend/front-page-category/css/responsive.css')}}" rel="stylesheet">
    <link href="{{ asset('frontend/common-css/swiper.css') }}" rel="stylesheet">
    <style>
		.slider {
			height: 280px;
			width: 100%;
			background-image:url({{ asset("images/allpost.jpg") }});
			background-size: cover;
		}
	</style>
@endpush

@push('banner')
    <div class="slider">
        <div class="display-table  center-text">
        <h1 class="title display-table-cell"><b>All Posts</b></h1>
        </div>
    </div><!-- slider -->  
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
												<li><a href="#"><i class="ion-heart"></i>57</a></li>
												<li><a href="#"><i class="ion-chatbubble"></i>6</a></li>
												<li><a href="#"><i class="ion-eye"></i>138</a></li>
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
    <script src="{{ asset('frontend/common-js/swiper.js') }}"></script>
@endpush
