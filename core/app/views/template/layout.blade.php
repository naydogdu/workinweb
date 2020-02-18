@if (Session::has('success'))
    <div class="pd24 alert bg-ok">{{ Session::get('success') }}</div>
@endif
<article>
	@yield('content')
</article>
