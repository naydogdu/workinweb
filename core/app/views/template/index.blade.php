<!doctype html>
<html lang="{{ trans('html.lang') }}">
<head>
	@include('template.head')
</head>
<body class="bg-whitebis">
	<header id="app-header" class="bg-blue pd24-0 z99 posrel clear">
		@include('template.header')
	</header>
	<main class="pd24-0">
		@include('template.layout')
	</main>
	<footer>
		@include('template.footer')
	</footer>
</body>
</html>