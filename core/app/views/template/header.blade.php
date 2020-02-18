<div class="wrap clear">
	{{ link_to_route('public.index', trans('nav.homeLink'), null, array( 'id' => 'app-logo', 'class' => 'homelink dis-ib pd12 col-white' ) ) }}
	{{ helpers::getAvatar() }}
	@include('template.nav.menu')
</div>

