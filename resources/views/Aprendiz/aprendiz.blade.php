@extends('layouts.headerLogged')
@section('title', 'Documentación certificación Etapa productiva')
@section('titleHeader', 'Documentación certificación Etapa productiva')
<link href="{{ asset('css/portal.css') }}" rel="stylesheet">
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<section class="page-section portfolio" id="quienes_somos">
  <div class="container">
    

    <div class="portal-container">
        <div class="portal-header">
            <h2 class="portal-title">PORTAL DE PLATAFORMAS CEET</h2>
            <p class="portal-subtitle">Los documentos deben ser en formato PDF y deben pesar menos de 5 MB</p>
        </div>

        <div class="user-info">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Nombre:</strong> {{ $usuario->Nombres }} {{ $usuario->Apellidos }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Documento:</strong> {{ $usuario->idUsuarios }}</p>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <form action="{{ route('aprendiz.subir') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <table class="table documents-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Nombre documento</th>
                            <th style="width: 15%;">Cargar documentos</th>
                            <th style="width: 8%;">✓</th>
                            <th style="width: 8%;">✗</th>
                            <th style="width: 29%;">Comentarios</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $mostrarBoton = false; @endphp
                        @foreach($documentos as $doc)
                            @php
                                $estado = strtolower($doc['estado'] ?? 'pendiente');
                                $aprobado = $estado === 'aprobado';
                                $rechazado = $estado === 'rechazado';
                                $pendiente = !$aprobado && !$rechazado;
                                if ($rechazado || !$doc['exists']) $mostrarBoton = true;
                            @endphp
                            <tr class="
                                @if($aprobado) document-approved 
                                @elseif($rechazado) document-rejected 
                                @else document-pending 
                                @endif
                            ">
                                <td class="document-name">
                                    {{ $doc['name'] }}
                                    <span class="required-indicator">*</span>
                                </td>

                                <td class="upload-col">
                                    @if($rechazado || !$doc['exists'])
                                        <label class="upload-btn" for="file_{{ $doc['field'] }}">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </label>
                                        <input 
                                            type="file" 
                                            id="file_{{ $doc['field'] }}" 
                                            name="{{ $doc['field'] }}" 
                                            accept="application/pdf" 
                                            style="display:none"
                                            onchange="document.getElementById('filename_{{ $doc['field'] }}').textContent = this.files[0]?.name || ''"
                                        >
                                        <div id="filename_{{ $doc['field'] }}" style="margin-top:5px; font-size: 12px; color: #555;"></div>
                                    @else
                                        <div style="font-size: 12px; color: #555;">Archivo enviado</div>
                                        @if($doc['ruta'])
                                            <a href="{{ $doc['ruta'] }}" target="_blank" style="font-size: 12px;">Ver documento</a>
                                        @endif
                                    @endif
                                </td>

                                <td class="checkbox-col text-center">
                                    @if($aprobado)
                                        <i class="fas fa-check-circle text-success" style="font-size: 20px;"></i>
                                    @else
                                        <i class="far fa-circle text-muted" style="font-size: 20px;"></i>
                                    @endif
                                </td>

                                <td class="checkbox-col text-center">
                                    @if($rechazado)
                                        <i class="fas fa-times-circle text-danger" style="font-size: 20px;"></i>
                                    @else
                                        <i class="far fa-circle text-muted" style="font-size: 20px;"></i>
                                    @endif
                                </td>

                                <td class="comments-col">
                                    <div class="comment-display">
                                        {{ $doc['comment'] ?? 'Sin comentarios' }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($mostrarBoton)
                    <div class="text-center">
                        <button type="submit" class="ready-btn">
                            Subir documentos
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
  </div>
</section>

@include('layouts.footer')
@endsection
