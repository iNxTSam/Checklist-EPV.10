<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Documentación Certificación CEET</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">

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
    <p>Estimado(a) Instructor: Por favor inicie sesión:</p>

    <form>
      <label for="documento">Número de Documento Instructor (Sólo números)</label>
      <input type="text" id="documento" name="documento" required>

      <label for="contrasena">Contraseña Plataforma Instructor</label>
      <input type="password" id="contrasena" name="contrasena" required>

      <a href="#" class="link">¿Olvidó su contraseña?</a>

      <div class="botones">
        <a href="/buscarFicha" class="aceptar">Aceptar</a>
         <a href="#" class="cancelar">Cancelar</a>
        </div>
    </form>

    <footer>
      <p><strong>Servicio Nacional de Aprendizaje SENA * CENTRO DE ELECTRICIDAD, ELECTRÓNICA Y TELECOMUNICACIONES-Regional Distrito Capital *
Subdirección: Lina Samaris Silva Beltrán
Coordinación: Mauricio Coronado - Germán Alarcón - Oscar Galvis - Yaqueline Chavarro - Oscar Pulido - Édgar Hincapié - Luís Antonio Ayala
Supervisión y Adminstración de la Plataforma: Coordinación Teleinformática CEET - GICS
Diseño y Desarrollo de la Plataforma: Grupo de Investigación GICS - CEET . Instructor: Fabián Rodríguez
Dirección:Cra 30 No. 17B-25 Sur. Bogotá-Teléfono: 5461500 Ext: 14915
Conmutador Nacional (57 1) 5461500
Atención telefónica: lunes a viernes 7:00 a.m. a 7:00 p.m. - sábados 8:00 a.m. a 1:00 p.m.
Atención al ciudadano: Bogotá (57 1) 5925555 - Línea gratuita y resto del país 018000 910270</p>
    </footer>
  </div>
</body>
</html>
