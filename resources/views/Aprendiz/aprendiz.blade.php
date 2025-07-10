@extends('layouts.header')
@section ('title', 'Documentación certificación Etapa productiva')
@section ('titleHeader', 'Documentación certificación Etapa productiva')
    <link href="{{ asset('css/portal.css') }}" rel="stylesheet">
@section('content')

<section class="page-section portfolio" id="quienes_somos">
  <div class="container" bis_skin_checked="1">

    <div class="portal-container">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
        <div class="portal-header">
            <h2 class="portal-title">PORTAL DE PLATAFORMAS CEET</h2>
            <p class="portal-subtitle">Los documentos deben ser en formato PDF y deben pesar menos de 5 MB</p>
        </div>
        
        <div class="user-info">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Nombre:</strong> Valentina Vasquez Rodriguez</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Documento:</strong> 1030556208</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Fecha:</strong> 25/06/06</p>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
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
                    @foreach($documents as $index => $document)
                    <tr class="@if($document['approved']) document-approved @elseif($document['rejected']) document-rejected @else document-pending @endif">
                        <td class="document-name">
                            {{ $document['name'] }}
                            @if($document['required'])
                                <span class="required-indicator">*</span>
                            @endif
                        </td>
                        <td class="upload-col">
                            <button class="upload-btn" onclick="uploadDocument({{ $index }})">
                                <i class="fas fa-cloud-upload-alt cloud-icon"></i>
                            </button>
                        </td>
                        <td class="checkbox-col">
                            <div class="status-indicator {{ $document['approved'] ? 'approved' : '' }}">
                                @if($document['approved'])
                                    <i class="fas fa-check-circle text-success" style="font-size: 20px;"></i>
                                @else
                                    <i class="far fa-circle text-muted" style="font-size: 20px;"></i>
                                @endif
                            </div>
                        </td>
                        <td class="checkbox-col">
                            <div class="status-indicator {{ $document['rejected'] ? 'rejected' : '' }}">
                                @if($document['rejected'])
                                    <i class="fas fa-times-circle text-danger" style="font-size: 20px;"></i>
                                @else
                                    <i class="far fa-circle text-muted" style="font-size: 20px;"></i>
                                @endif
                            </div>
                        </td>
                        <td class="comments-col">
                            <div class="comment-display">
                                {{ $document['comment'] }}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="text-center">
            <button class="ready-btn" onclick="submitDocuments()">
                Listo
            </button>
        </div>
    </div>


@include('layouts.footer')

<script>
function uploadDocument(index) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.pdf';
    input.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('El archivo debe pesar menos de 5 MB');
                return;
            }
            if (file.type !== 'application/pdf') {
                alert('Solo se permiten archivos PDF');
                return;
            }
            alert('Archivo ' + file.name + ' cargado correctamente (simulación)');
        }
    };
    input.click();
}

function submitDocuments() {
    alert('Vista de documentos - Solo lectura');
}
</script>
@endsection