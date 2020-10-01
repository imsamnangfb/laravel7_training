@include('layouts.front.head')
<body>

@include('layouts.front.header')
    @stack('banner')
	<section class="blog-area section">
		<div class="container">
			@yield('content')
		</div><!-- container -->
	</section><!-- section -->

    @include('layouts.front.footer')
	<!-- SCIPTS -->
    @include('layouts.front.script')

</body>
</html>
