@extends('layouts.header')
@section ('title', 'Documentación certificación Etapa productiva')
@section ('titleHeader', 'Documentación certificación Etapa productiva')
<link rel="stylesheet" href="{{'css/buscarFicha.css'}}">
@include('layouts.slider')
    <div class="content">

<p><strong>Respetado(a) Usuario(a) CEET:</strong> La plataforma "DOCUMENTACIÓN CERTIFICACIÓN CEET", ha sido desarrollada para
  la
  gestión de documentos y certificación de la Comunidad CEET.</p>
        <form action="/instructor" method="get">
            <div class="form-group">
                <label for="ficha">Ingrese el número de ficha (Sólo números)</label><br><br>
                <input type="text" id="ficha" name="ficha" placeholder="Nº Ficha" required>
            </div>
            <p align="center"><a href="/instructor" class="button">Aceptar</a></p><br>
            <p align="center"><a href="/" >Cancelar y salir</a></p>
        </form>
    </div>

@include('layouts.footer')
