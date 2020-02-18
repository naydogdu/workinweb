<!doctype html>
<html lang="{{ trans('html.lang') }}">
<head>
	@include('template.head')
</head>
<body class="bg-blue loginpage col-white">
	<header id="app-header" class="pd24-0 pdb0 clear">
		<div class="wrap clear tac pd48-0">
			{{ link_to_route('public.index', trans('nav.homeLink'), null, array( 'id' => 'app-logo', 'class' => 'homelink dis-ib pd12 col-white' ) ) }}
		</div>
	</header>
	<main>
		@yield('content')
	</main>
	<footer class="pd48-0">
		<div class="wrap clear tac">
			@if( $view_name !== 'connection.login' )
				{{ link_to('', trans('pagination.backTo'), array('class' => 'dis-ib pd8 col-white')) }}	
			@endif
			{{ link_to('?forgot', trans('auth.forgotLink'), array('class' => 'dis-ib pd8 col-white')) }}		
			{{ link_to('?register', trans('auth.registerLink'), array('class' => 'dis-ib pd8 col-white')) }}
		</div>
	</footer>
</body>
</html>