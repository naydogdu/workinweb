<!DOCTYPE html>
<html lang="fr-FR">
    <head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>@lang('reminders.forgotMail.title')</h2>

		<div>
			@lang('reminders.forgotMail.text') <a href="{{ URL::to('?reset='. $token) }}">@lang('reminders.forgotMail.text2')</a>.
		</div>
	</body>
</html>