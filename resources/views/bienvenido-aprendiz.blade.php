<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido Aprendiz</title>
</head>
<body>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
        <button type="submit" class="aceptar">Cerrar sesión</button>
    </form>
    <h1>¡Bienvenido Aprendiz!</h1>
</body>
</html>
