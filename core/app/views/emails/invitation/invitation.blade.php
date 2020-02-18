<!DOCTYPE html>
<html lang="fr-FR">
    <head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>@lang('admin.mail.title')</h2>

		<div>
			<p>	@lang('admin.mail.content1') : {{ $email }}</p>
			<p> @lang('admin.mail.content2') : {{ $pswd }} </p>
			<p>@lang('admin.mail.content3') <a href="{{ URL::to('/') }}">@lang('admin.mail.workinweb')</a>.</p>
			<p> @lang('admin.mail.content4')</p>
		</div>
	</body>
</html>