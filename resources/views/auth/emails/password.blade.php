<h3>Cambiar Contraseña</h3>
<hr>
Clic para cambiar su contraseña:<br>
<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">
	{{ $link }}
</a>
