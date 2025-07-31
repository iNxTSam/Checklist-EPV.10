@extends('layouts.header')
@section ('title', 'Documentación certificación Etapa productiva')
@section ('titleHeader', 'Documentación certificación Etapa productiva')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@section('content')
@include('layouts.slider')
<div class="content">
<p><strong>Respetado(a) Usuario(a) CEET:</strong> La plataforma "DOCUMENTACIÓN CERTIFICACIÓN CEET", ha sido desarrollada para
  la
  gestión de documentos y certificación de la Comunidad CEET.</p>
<p><strong>Inicio de sesión para Instructores, Coordinaciones, Apoyos y Subdirección.</strong></p>

@if($errors->any())
    <div class="errores" style="color:red;">
    {{ $errors->first('error') }}
    </div>
  @endif
<form method="post" action="{{ route('login.instructor') }}">
  @csrf
  <label for="documento">Número de Documento Instructor *(Sólo números)</label>
  <input type="text" id="numeroDocumento" name="numeroDocumento" required>

  <label for="contrasena">Contraseña de acceso</label>
  <input type="password" id="clave" name="clave" required>

  <a href="#" class="link">¿Olvidó su contraseña?</a>


    <p align="center"><button type="submit" class="aceptar" >Aceptar</button></p>
    <p align="center"><a href="/" class="cancelar">Cancelar y salir</a></p>

</form>
</div>
@include('layouts.footer')
@endsection