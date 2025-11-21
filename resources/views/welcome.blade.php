<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Wheel Fire Club - Login</title>
</head>
<body>

<h2>Iniciar Sesión</h2>

<form action="{{ route('player.login') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nombre" required>
    <button type="submit">Entrar</button>
</form>

<h2>Registrarse</h2>

<form action="{{ route('player.register') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nombre" required>
    <button type="submit">Crear jugador</button>
</form>

</body>
</html>
