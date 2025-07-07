@extends('layouts.header')
@section ('title', 'Documentación certificación Etapa productiva')
@section ('titleHeader', 'Documentación certificación Etapa productiva')
    <link href="{{ asset('css/portal.css') }}" rel="stylesheet">
@section('content')

<section class="page-section portfolio" id="quienes_somos">
  <div class="container" bis_skin_checked="1">


<div class="content">
    <div class="portal-container">
        <div class="portal-header">
            <h2 class="portal-title">REVISIÓN DE DOCUMENTOS</h2>
            <p class="portal-subtitle">Revisar, aprobar y comentar documentos del estudiante</p>
        </div>
        
        <div class="student-review-info">
            <div class="row">
                <div class="col-md-3">
                    <p><strong>Estudiante:</strong> {{ $student['name'] }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Documento:</strong> {{ $student['document'] }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Programa:</strong> {{ $student['program'] }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Fecha Envío:</strong> {{ \Carbon\Carbon::parse($student['submitted_at'])->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <div class="review-actions">
            <button class="btn btn-success" onclick="approveAllPending()">
                <i class="fas fa-check-circle"></i> Aprobar Todos Pendientes
            </button>
            <button class="btn btn-warning" onclick="markAllPending()">
                <i class="fas fa-clock"></i> Marcar Todos Pendiente
            </button>
            <button class="btn btn-info" onclick="saveAllChanges()">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
        
        <div class="table-responsive">
            <table class="table review-table">
                <thead>
                    <tr>
                        <th style="width: 30%;">Documento</th>
                        <th style="width: 15%;">Archivo</th>
                        <th style="width: 8%;">Aprobar</th>
                        <th style="width: 8%;">Rechazar</th>
                        <th style="width: 10%;">Estado</th>
                        <th style="width: 29%;">Comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                    <tr class="document-row document-pending" data-document-id="{{ $document['id'] }}">
                        <td class="document-name">
                            <strong>{{ $document['name'] }}</strong>
                            @if($document['required'])
                                <span class="required-indicator">*</span>
                            @endif
                            @if($document['uploaded_at'])
                                <br><small class="text-muted">
                                    Subido: {{ \Carbon\Carbon::parse($document['uploaded_at'])->format('d/m/Y H:i') }}
                                </small>
                            @endif
                        </td>
                        <td class="file-col">
                            @if($document['file_path'])
                                <button class="btn btn-sm btn-outline-primary" onclick="viewDocument('{{ $document['file_path'] }}')">
                                    <i class="fas fa-file-pdf"></i> Ver PDF
                                </button>
                                <button class="btn btn-sm btn-outline-secondary mt-1" onclick="downloadDocument('{{ $document['file_path'] }}')">
                                    <i class="fas fa-download"></i> Descargar
                                </button>
                            @else
                                <span class="text-muted">
                                    <i class="fas fa-file-times"></i> Sin archivo
                                </span>
                            @endif
                        </td>
                        <td>
                            <input type="checkbox" 
                                   class="approve-checkbox" 
                                   data-document-id="{{ $document['id'] }}"
                                   {{ $document['approved'] ? 'checked' : '' }}
                                   onchange="updateDocumentStatus({{ $document['id'] }}, 'approve', this.checked)">
                        </td>
                        <td>
                            <input type="checkbox" 
                                   class="reject-checkbox" 
                                   data-document-id="{{ $document['id'] }}"
                                   {{ $document['rejected'] ? 'checked' : '' }}
                                   onchange="updateDocumentStatus({{ $document['id'] }}, 'reject', this.checked)">
                        </td>
                        <td>
                            <span class="status-indicator-small" id="status-{{ $document['id'] }}">
                                @if($document['approved'])
                                    <i class="fas fa-check-circle text-success"></i>
                                @elseif($document['rejected'])
                                    <i class="fas fa-times-circle text-danger"></i>
                                @else
                                    <i class="fas fa-clock text-warning"></i>
                                @endif
                            </span>
                        </td>
                        <td>
                            <textarea class="form-control comment-textarea" 
                                      rows="3" 
                                      data-document-id="{{ $document['id'] }}"
                                      placeholder="Escribir comentarios...">{{ $document['comment'] }}</textarea>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="final-actions">
            <div class="row">
                <div class="col-md-6">
                    <h5>Estado General del Estudiante:</h5>
                    <select class="form-select" id="overall-status">
                        <option value="pending">Pendiente</option>
                        <option value="approved">Aprobado</option>
                        <option value="revision">En Revisión</option>
                        <option value="rejected">Rechazado</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <h5>Comentario General:</h5>
                    <textarea class="form-control" id="general-comment" rows="3" placeholder="Comentario general sobre todos los documentos..."></textarea>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-success btn-lg" onclick="submitReview()">
                <i class="fas fa-check"></i> Finalizar Revisión
            </button>
            <button class="btn btn-secondary btn-lg ms-3" onclick="saveDraft()">
                <i class="fas fa-save"></i> Guardar Borrador
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="documentModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Visor de Documentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe id="documentViewer" style="width: 100%; height: 600px;" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="downloadCurrentDocument()">
                    <i class="fas fa-download"></i> Descargar
                </button>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')

<script>
let currentDocumentPath = '';

function updateDocumentStatus(documentId, action, checked) {
    const row = document.querySelector(`[data-document-id="${documentId}"]`);
    const approveCheckbox = row.querySelector('.approve-checkbox');
    const rejectCheckbox = row.querySelector('.reject-checkbox');
    const statusIcon = document.getElementById(`status-${documentId}`);

    if (action === 'approve' && checked) {
        rejectCheckbox.checked = false;
        statusIcon.innerHTML = '<i class="fas fa-check-circle text-success"></i>';
        row.className = 'document-row document-approved';
    } else if (action === 'reject' && checked) {
        approveCheckbox.checked = false;
        statusIcon.innerHTML = '<i class="fas fa-times-circle text-danger"></i>';
        row.className = 'document-row document-rejected';
    } else {
        statusIcon.innerHTML = '<i class="fas fa-clock text-warning"></i>';
        row.className = 'document-row document-pending';
    }
}

function viewDocument(filePath) {
    currentDocumentPath = filePath;
    document.getElementById('documentViewer').src = filePath;
    new bootstrap.Modal(document.getElementById('documentModal')).show();
}

function downloadDocument(filePath) {
    const a = document.createElement('a');
    a.href = filePath;
    a.download = '';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

function downloadCurrentDocument() {
    if (currentDocumentPath) {
        downloadDocument(currentDocumentPath);
    }
}

function approveAllPending() {
    document.querySelectorAll('.document-row').forEach(row => {
        const approve = row.querySelector('.approve-checkbox');
        const reject = row.querySelector('.reject-checkbox');
        const status = row.querySelector('.status-indicator-small');
        approve.checked = true;
        reject.checked = false;
        row.className = 'document-row document-approved';
        status.innerHTML = '<i class="fas fa-check-circle text-success"></i>';
    });
}

function markAllPending() {
    document.querySelectorAll('.document-row').forEach(row => {
        const approve = row.querySelector('.approve-checkbox');
        const reject = row.querySelector('.reject-checkbox');
        const status = row.querySelector('.status-indicator-small');
        approve.checked = false;
        reject.checked = false;
        row.className = 'document-row document-pending';
        status.innerHTML = '<i class="fas fa-clock text-warning"></i>';
    });
}

function saveAllChanges() {
    alert("Cambios guardados temporalmente.");
}

function submitReview() {
    alert("Revisión enviada correctamente.");
}

function saveDraft() {
    alert("Borrador guardado.");
}
</script>



@endsection
