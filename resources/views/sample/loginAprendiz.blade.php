@extends('layouts.header')
@section ('title', 'Documentación certificación Etapa productiva')
@section ('titleHeader', 'Documentación certificación Etapa productiva')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@section('content')
@include('layouts.slider')
<div class="content">
<p><strong>Respetado(a) Usuario(a) Teleinformática y Telecomunicaciones CEET</strong> La plataforma "DOCUMENTACIÓN CERTIFICACIÓN CEET", ha sido desarrollada para
  la
  gestión de documentos y certificación de la Comunidad CEET.</p>
<p><strong>Inicio de sesión para Instructores, Coordinaciones, Apoyos y Subdirección.</strong></p>

<form>
  <label for="documento">Número de Documento Aprendiz *(Sólo números)</label>
  <input type="text" id="documento" name="documento" required>

  <label for="contrasena">Contraseña de acceso</label>
  <input type="password" id="contrasena" name="contrasena" required>

  <a href="#" class="link">¿Olvidó su contraseña?</a>


    <p align="center"><a href="/aprendiz" class="aceptar" >Aceptar</a></p>
    <p align="center"><a href="/" class="cancelar">Cancelar y salir</a></p>

</form>
</div>
@include('layouts.footer')