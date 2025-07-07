    @extends('layouts.header')
    @section ('title', 'Documentación certificación Etapa productiva')
    @section ('titleHeader', 'Documentación certificación Etapa productiva')

    <link rel="stylesheet" href="{{ asset('css/indexSample.css') }}">
    @section('content')
    @include('layouts.slider')
            <div class="wrapper">

                <div class="content">
                    <p><strong>Respetado(a) Usuario(a):</strong> La plataforma "DOCUMENTACIÓN CERTIFICACIÓN CEET", ha sido desarrollada para la
                        gestión de documentos y certificación de la Comunidad CEET.</p>
                    <div class="buttons">
                        <div class="button-container">
                            <img src="{{ asset('img/instructor.jpg') }}" alt="Soy Colaborador(a) CEET" class="button-image">
                            <a href="/instructorLogin" class="button-text">Soy Instructor / Usuario CEET</a>
                        </div>
                        <div class="button-container">
                            <img src="{{ asset('img/aprendiz.jpg') }}" alt="Soy Aprendiz(a)" class="button-image">
                            <a href="/aprendizLogin" class="button-text">Soy Aprendiz(a)</a>
                        </div>
                    </div>
                    <p align="center"><a href="/"><img src="{{ 'img/icono_salir.png' }}" width="25" height="25">Regresar al Portal CEET </a></p>
                </div>
                @include('layouts.footer')
    @endsection