<nav class="posrel main-nav dis-ib floatr">
	{{ link_to_route('public.index', trans('nav.homeLink'), null, array( 'class' => 'homelink dis-ib pd12 col-white' ) ) }}
	{{ link_to_route('project.index', trans('nav.projectLink'), null, array( 'class' => 'projectlink dis-ib pd12 col-white' ) ) }}
	<a href="#" id="main-nav-menu-toggle" class="dis-ib pd12 col-white"><i class="fa fa-bars"></i></a>
	<ul id="main-nav-menu" class="posabs r0 z99 bg-white mrg24-0 mb0">			
		<a href="{{ URL::route('profil.edit', array('id' => Auth::id() )) }}" class="dis-b pd12-24 bb1-grey"><i class="fa fa-user"></i> {{ trans('profil.editProfil') }}</a>
		@if( Auth::user()->role_id === 1 )
			<a href="{{ URL::route('admin.index') }}" class="adminlink dis-b pd12-24 bb1-grey"><i class="fa fa-rocket"></i> {{ trans('nav.adminLinkLabel') }}</a>
		@endif
		<a href="{{ URL::to('?loggedout') }}" class="dis-b pd12-24"><i class="fa fa-power-off"></i> {{ trans('nav.logout') }}</a>
	</ul>
</nav>