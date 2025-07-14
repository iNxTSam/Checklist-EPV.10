@extends('layouts.header')
@section('title', 'Documentación certificación Etapa productiva')
@section('titleHeader', 'Documentación certificación Etapa productiva')
<link rel="stylesheet" href="{{ asset('css/buscarFicha.css') }}">
@include('layouts.slider')

<div class="content">
    <p><strong>Respetado(a) Usuario(a) CEET:</strong> La plataforma "DOCUMENTACIÓN CERTIFICACIÓN CEET", ha sido desarrollada para la gestión de documentos y certificación de la Comunidad CEET.</p>

    <form action="{{ route('ficha.buscar') }}" method="GET">

        <div class="form-group">
            <label for="ficha">Ingrese el número de ficha (Sólo números)</label><br><br>
            <input type="text" id="ficha" name="ficha" placeholder="Nº Ficha" required>
        </div>
        <p align="center">
            <button type="submit" class="button">Aceptar</button>
        </p><br>
        <p align="center"><a href="/">Cancelar y salir</a></p>
    </form>

    @if(session('mensaje') === 'Ficha no encontrada')
        <p style="color:red; text-align: center;">Ficha no encontrada.</p>
    @endif
</div>

@include('layouts.footer')
