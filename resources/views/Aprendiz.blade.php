<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Documentación Certificación CEET</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
  <div class="contenedor">
    <h1>DOCUMENTACIÓN CERTIFICACIÓN CEET</h1>

    <div class="cabecera">
      <img src="https://upload.wikimedia.org/wikipedia/commons/5/58/Logo_SENA.svg" alt="Logo SENA" class="logo-sena">
      <div class="titulo-cabecera">
        <h2>Centro de Electricidad<br>Electrónica y Telecomunicaciones</h2>
        <p>Regional Distrito Capital</p>
      </div>
      <img src="https://www.ceet.edu.co/images/galeria/5.jpg" alt="Imagen" class="imagen-lateral">
    </div>

    <h3>Documentación certificación - Etapa productiva</h3>
    <p>Estimado(a) Aprendiz: Por favor inicie sesión:</p>

    {{-- Mostrar mensaje de error si hay --}}
    @if($errors->any())
      <div class="errores" style="color:red;">
        {{ $errors->first('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login.aprendiz') }}">
      @csrf
      <label for="documento">Número de Documento Aprendiz (Sólo números)</label>
      <input type="text" id="documento" name="numero_documento" required>

      <label for="contrasena">Contraseña Plataforma Aprendiz</label>
      <input type="password" id="contrasena" name="password" required>

      <a href="#" class="link">¿Olvidó su contraseña?</a>

      <div class="botones">
        <button type="submit" class="aceptar">Aceptar</button>
        <button type="reset" class="cancelar">Cancelar</button>
      </div>
    </form>

    <footer>
      <p><strong>Servicio Nacional de Aprendizaje SENA * CENTRO DE ELECTRICIDAD, ELECTRÓNICA Y TELECOMUNICACIONES - Regional Distrito Capital *</strong><br>
      Subdirección: Lina Samaris Silva Beltrán<br>
      Coordinación: Mauricio Coronado - Germán Alarcón - Oscar Galvis - Yaqueline Chavarro - Oscar Pulido - Édgar Hincapié - Luís Antonio Ayala<br>
      Supervisión y Administración de la Plataforma: Coordinación Teleinformática CEET - GICS<br>
      Diseño y Desarrollo de la Plataforma: Grupo de Investigación GICS - CEET<br>
      Instructor: Fabián Rodríguez<br>
      Dirección: Cra 30 No. 17B-25 Sur. Bogotá<br>
      Teléfono: 5461500 Ext: 14915<br>
      Atención telefónica: Lunes a Viernes 7:00 a.m. - 7:00 p.m. / Sábados 8:00 a.m. - 1:00 p.m.<br>
      Atención al ciudadano: Bogotá (57 1) 5925555 - Línea gratuita resto del país 018000 910270</p>
    </footer>
  </div>
</body>
</html>
