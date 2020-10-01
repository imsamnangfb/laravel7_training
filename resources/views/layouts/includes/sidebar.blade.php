@section('sidebar')
	<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">

			<!-- Sidebar user panel (optional) -->
			<div class="user-panel">
				<div class="pull-left image">
				<img src="{{ asset('uploads/user/'.auth()->user()->image) }}" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
				<p>Alexander Pierce</p>
				<!-- Status -->
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
				</div>
			</div>

			<!-- search form (Optional) -->
			<form action="#" method="get" class="sidebar-form">
							<div class="input-group">
							<input type="text" name="q" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
											<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
											</button>
											</span>
							</div>
			</form>
			<!-- /.search form -->
      @if (auth()->user()->role->id==1)
        <!-- Sidebar Menu -->
			<ul class="sidebar-menu" data-widget="tree">
				<!-- Optionally, you can add icons to the links -->
				<li class="active"><a href="#"><i class="fa  fa-home"></i> <span>Dashboard</span></a></li>
					{{-- roles menu --}}
					<li class="treeview">
						<a href="#"><i class="fa fa-th-list"></i> <span>Manage Roles</span>
								<span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
								</span>
						</a>
						<ul class="treeview-menu">
								<li><a href="{{ route('admin.roles.create')}}"><i class="fa  fa-plus"></i>Add Role</a></li>
								<li><a href="{{ route('admin.roles.index') }}"><i class="fa fa-reorder"></i>List Roles</a></li>
						</ul>
					</li>
					{{-- roles menu --}}
					<li class="treeview">
						<a href="#"><i class="fa fa-th-list"></i> <span>Manage User</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
								<li><a href="{{ route('admin.users.create')}}"><i class="fa  fa-plus"></i>Add User</a></li>
								<li><a href="{{ route('admin.users.index') }}"><i class="fa fa-reorder"></i>List Users</a></li>
						</ul>
					</li>
				{{-- tag menu --}}
				<li class="treeview">
					<a href="#"><i class="fa fa-th-list"></i> <span>Manage Tags</span>
							<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
							</span>
					</a>
					<ul class="treeview-menu">
							<li><a href="{{ route('admin.tags.create')}}"><i class="fa  fa-plus"></i>Add Tag</a></li>
							<li><a href="{{ route('admin.tags.index') }}"><i class="fa fa-reorder"></i>List Tags</a></li>
					</ul>
				</li>
				{{-- category menu --}}
				<li class="treeview">
					<a href="#"><i class="fa fa-th-list"></i> <span>Manage Categories</span>
							<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
							</span>
					</a>
					<ul class="treeview-menu">
							<li><a href="{{ route('admin.categories.create') }}"><i class="fa  fa-plus"></i>Add Category</a></li>
							<li><a href="{{ route('admin.categories.list') }}"><i class="fa fa-reorder"></i>List Category</a></li>
					</ul>
				</li>
				{{-- post menu --}}
				<li class="treeview">
					<a href="#"><i class="fa fa-th-list"></i> <span>Manage Posts</span>
							<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
							</span>
					</a>
					<ul class="treeview-menu">
							<li><a href="{{ route('admin.posts.create') }}"><i class="fa  fa-plus"></i>Add Post</a></li>
							<li><a href="{{ route('admin.posts.index') }}"><i class="fa fa-reorder"></i>List Posts</a></li>
							<li><a href="{{ route('admin.posts.pending') }}"><i class="fa fa-reorder"></i>Pending Posts</a></li>
							<li><a href="{{ route('admin.posts.gallery') }}"><i class="fa fa-reorder"></i>Post Gallery</a></li>
							<li><a href="{{ route('admin.posts.gallery.list') }}"><i class="fa fa-reorder"></i>Gallery List</a></li>
					</ul>
				</li>
				<li><a href="#"><i class="fa fa-align-justify"></i> <span>Subscribers</span></a></li>
      </ul>
      @elseif(auth()->user()->role->id==2)
			<!-- Sidebar Menu -->
			<ul class="sidebar-menu" data-widget="tree">
				<!-- Optionally, you can add icons to the links -->
				<li class="active"><a href="#"><i class="fa  fa-home"></i> <span>Dashboard</span></a></li>
					{{-- roles menu --}}
					{{-- <li class="treeview">
						<a href="#"><i class="fa fa-th-list"></i> <span>Manage Roles</span>
								<span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
								</span>
						</a>
						<ul class="treeview-menu">
								<li><a href="{{ route('admin.roles.create')}}"><i class="fa  fa-plus"></i>Add Role</a></li>
								<li><a href="{{ route('admin.roles.index') }}"><i class="fa fa-reorder"></i>List Roles</a></li>
						</ul>
					</li> --}}
					{{-- roles menu --}}
					{{-- <li class="treeview">
						<a href="#"><i class="fa fa-th-list"></i> <span>Manage User</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
								<li><a href="{{ route('admin.users.create')}}"><i class="fa  fa-plus"></i>Add User</a></li>
								<li><a href="{{ route('admin.users.index') }}"><i class="fa fa-reorder"></i>List Users</a></li>
						</ul>
					</li> --}}
				{{-- tag menu --}}
				{{-- <li class="treeview">
					<a href="#"><i class="fa fa-th-list"></i> <span>Manage Tags</span>
							<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
							</span>
					</a>
					<ul class="treeview-menu">
							<li><a href="{{ route('admin.tags.create')}}"><i class="fa  fa-plus"></i>Add Tag</a></li>
							<li><a href="{{ route('admin.tags.index') }}"><i class="fa fa-reorder"></i>List Tags</a></li>
					</ul>
				</li> --}}
				{{-- category menu --}}
				{{-- <li class="treeview">
					<a href="#"><i class="fa fa-th-list"></i> <span>Manage Categories</span>
							<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
							</span>
					</a>
					<ul class="treeview-menu">
							<li><a href="{{ route('admin.categories.create') }}"><i class="fa  fa-plus"></i>Add Category</a></li>
							<li><a href="{{ route('admin.categories.list') }}"><i class="fa fa-reorder"></i>List Category</a></li>
					</ul>
				</li> --}}
				{{-- post menu --}}
				<li class="treeview">
					<a href="#"><i class="fa fa-th-list"></i> <span>Manage Posts</span>
							<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
							</span>
					</a>
					<ul class="treeview-menu">
							<li><a href="{{ route('author.posts.create') }}"><i class="fa  fa-plus"></i>Add Post</a></li>
							<li><a href="{{ route('author.posts.index') }}"><i class="fa fa-reorder"></i>List Posts</a></li>
							<li><a href="{{ route('author.posts.pending') }}"><i class="fa fa-reorder"></i>Pending Posts</a></li>
					</ul>
        </li>

				<li><a href="#"><i class="fa fa-align-justify"></i> <span>Subscribers</span></a></li>
			</ul>
      @endif

			<!-- /.sidebar-menu -->
			</section>
			<!-- /.sidebar -->
	</aside>
@show
