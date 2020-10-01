<header>
	<div class="container-fluid position-relative no-side-padding">
		<a href="#" class="logo"><img src="{{ asset('frontend/images/logo.png') }}" alt="Logo Image"></a>
			<div class="menu-nav-icon" data-nav-menu="#main-menu"><i class="ion-navicon"></i></div>
			@guest
				{{-- left menu --}}
				<ul class="main-menu visible-on-click float-left" id="main-menu">
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ route('allPost') }}">Posts</a></li>
				</ul><!-- main-menu -->
				{{-- right menu --}}
				<ul class="main-menu visible-on-click float-right" id="main-menu">
					<li><a href="{{ route('register') }}">Sign Up</a></li>
					<li><a href="{{ route('login') }}">Log In</a></li>
				</ul>
			@else
				{{-- left menu --}}
				<ul class="main-menu visible-on-click float-left" id="main-menu">
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ route('allPost') }}">Posts</a></li>
					@if (auth()->user()->id==1)
						<li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
					@elseif(auth()->user()->id==2)
						<li><a href="{{ route('author.dashboard') }}">Dashboard</a></li>
					@endif
				</ul><!-- main-menu -->
				{{-- right menu --}}
				<ul class="main-menu visible-on-click float-right" id="main-menu">
					<li><a href="#">{{ auth()->user()->name }}</a></li>
						<li><a href="{{ route('logout') }}"
							onclick="event.preventDefault();
							document.getElementById('logout-form').submit();"
							>Logout</a>
						</li>
				</ul>
			@endguest
	<div class="src-area">
			<form>
					<button class="src-btn" type="submit"><i class="ion-ios-search-strong"></i></button>
					<input class="src-input" type="text" placeholder="Type of search">
			</form>
	</div>

	</div><!-- conatiner -->
</header>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
