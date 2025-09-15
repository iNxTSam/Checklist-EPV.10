@extends('layouts.headerLogged')
@section('title', 'Documentación certificación Etapa productiva')
@section('titleHeader', 'Documentación certificación Etapa productiva')
<link rel="stylesheet" href="{{ asset('css/buscarFicha.css') }}">
@include('layouts.slider')

<div class="content">
    <p><strong>Respetado(a) Usuario(a) CEET:</strong> La plataforma "DOCUMENTACIÓN CERTIFICACIÓN CEET", ha sido desarrollada para la gestión de documentos y certificación de la Comunidad CEET.</p>
 
        <table>
                <tr>
                    <th>Fichas asignadas</th>
                </tr>
        
               @foreach ($fichas as $ficha )
               <tr><td><a href="{{ route('instructor.ficha.buscar', $ficha->idFichas) }}">{{ $ficha->NumeroDeFicha }}</a></td></tr>
               @endforeach
        </table>

    @if(session('mensaje') === 'Ficha no encontrada')
        <p style="color:red; text-align: center;">Ficha no encontrada.</p>
    @endif
    @if(session('mensaje'))
    <div class="alert alert-danger">
        {{ session('mensaje') }}
    </div>
    @endif

</div>

@include('layouts.footer')