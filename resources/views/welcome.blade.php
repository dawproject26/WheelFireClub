<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Wheel Fire Club - Login</title>
</head>
<body>

<form action="{{ route('player.register') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nombre" required>
    <button type="submit">Jugar</button>
</form>

</body>
</html>
