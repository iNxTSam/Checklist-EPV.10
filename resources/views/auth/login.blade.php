<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Plataforma</title>
</head>
<body>
    <h2>Inicio de sesión - Etapa productiva</h2>

    @if($errors->any())
        <div style="color:red;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <label for="numero_documento">Número de Documento:</label><br>
        <input type="text" name="numero_documento" required><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Aceptar</button>
        <button type="reset">Cancelar</button>
    </form>
</body>
</html>
