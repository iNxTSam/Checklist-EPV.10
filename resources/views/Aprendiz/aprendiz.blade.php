@extends('layouts.app')

@section('title', 'Portal CEET - Plataformas')

@section('content')
<div class="header-sena">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-2">
                <div class="sena-logo">
                    <img src="{{ asset('img/logo-sena.png') }}" alt="Logo SENA" style="max-height: 60px;">
                </div>
            </div>
            <div class="col-md-6">
                <h1 class="header-title">Centro de Electricidad, Electrónica y Telecomunicaciones</h1>
                <p class="header-subtitle">Regional Distrito Capital</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="hero-image">
                    <span>Imagen<br>Representativa<br>CEET</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="portal-container">
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
</div>

<div class="footer-info">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p><strong>Servicio Nacional de Aprendizaje SENA - CENTRO DE ELECTRICIDAD, ELECTRÓNICA Y TELECOMUNICACIONES</strong><br>
                Dirección: Calle 52 No. 13 - 65 Bogotá D.C., Colombia • Código Postal: 111321<br>
                Subdirección: Luis Eduardo Silva Bohórquez<br>
                Coordinación Académica: Mercedes Sánchez, John Jaír Galindo Alzate, Luz Adriana Angel<br>
                Diseño y Desarrollo de las Plataformas: Grupo de Investigaciones GIC2 - CEET • Webmaster: Fabián Rodríguez<br>
                PBXdigital: (601) 546 1500 Ext. 15402 • E-mail: ceet@sena.edu.co<br><br>
                Atención telefónica lunes a viernes 7:00 a.m. a 7:00 p.m. • Sábados 8:00 a.m. a 1:00 p.m.<br>
                Excluye días festivos • Tel. 57 (1) 5461500 • Línea gratuita desde celular 018000 910270</p>
            </div>
        </div>
    </div>
</div>

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