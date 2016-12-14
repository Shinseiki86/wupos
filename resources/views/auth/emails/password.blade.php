<h3>Cambiar Contraseña</h3>
<hr>
Usuario: {{ $user->username }}<br>
Clic para cambiar su contraseña:<br>
<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">
	{{ $link }}
</a>
