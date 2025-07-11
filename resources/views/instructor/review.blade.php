@extends('layouts.header')
@section('title', 'Documentación certificación Etapa productiva')
@section('titleHeader', 'Documentación certificación Etapa productiva')
<link href="{{ asset('css/portal.css') }}" rel="stylesheet">
@section('content')

<section class="page-section portfolio">
  <div class="container">
    <div class="portal-container">
      <div class="portal-header">
        <h2 class="portal-title">REVISIÓN DE DOCUMENTOS</h2>
        <p class="portal-subtitle">Revisar, aprobar y comentar documentos del estudiante</p>
      </div>

      <div class="student-review-info row mb-3">
        <div class="col-md-3"><strong>Estudiante:</strong> {{ $student['name'] }}</div>
        <div class="col-md-3"><strong>Documento:</strong> {{ $student['document'] }}</div>
        <div class="col-md-3"><strong>Programa:</strong> {{ $student['program'] }}</div>
        <div class="col-md-3"><strong>Fecha Envío:</strong> {{ \Carbon\Carbon::parse($student['submitted_at'])->format('d/m/Y') }}</div>
      </div>

      <form method="POST" action="{{ route('instructor.guardarRevision', $student['id']) }}">
        @csrf

        <div class="table-responsive">
          <table class="table review-table">
            <thead>
              <tr>
                <th>Documento</th>
                <th>Archivo</th>
                <th>Aprobar</th>
                <th>Rechazar</th>
                <th>Estado</th>
                <th>Comentarios</th>
              </tr>
            </thead>
<tbody>
@foreach($documents as $document)
@php
    $rowClass = $document['approved'] ? 'document-approved' :
                ($document['rejected'] ? 'document-rejected' : 'document-pending');
@endphp
<tr class="document-row {{ $rowClass }}" data-document-id="{{ $document['id'] }}">
    <td>
        <strong>{{ $document['name'] }}</strong>
        @if($document['uploaded_at'])
            <br><small class="text-muted">Subido: {{ \Carbon\Carbon::parse($document['uploaded_at'])->format('d/m/Y H:i') }}</small>
        @endif
    </td>
    <td>
        @if($document['file_path'])
            <a href="{{ $document['file_path'] }}" target="_blank" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-file-pdf"></i> Ver
            </a>
        @else
            <span class="text-muted">Sin archivo</span>
        @endif
    </td>
    <td class="checkbox-col text-center">
        <input type="checkbox" class="approve-checkbox checkbox-custom" data-document-id="{{ $document['id'] }}"
            {{ $document['approved'] ? 'checked' : '' }}>
    </td>
    <td class="checkbox-col text-center">
        <input type="checkbox" class="reject-checkbox checkbox-custom" data-document-id="{{ $document['id'] }}"
            {{ $document['rejected'] ? 'checked' : '' }}>
    </td>
    <td class="text-center">
        <span class="status-indicator 
            {{ $document['approved'] ? 'approved' : ($document['rejected'] ? 'rejected' : '') }}">
            @if ($document['approved'])
                <i class="fas fa-check-circle"></i>
            @elseif ($document['rejected'])
                <i class="fas fa-times-circle"></i>
            @else
                <i class="fas fa-clock text-warning"></i>
            @endif
        </span>
    </td>
    <td>
        <textarea class="form-control comment-textarea" rows="2" data-document-id="{{ $document['id'] }}">{{ $document['comment'] }}</textarea>
    </td>

    {{-- Campos ocultos por documento --}}
    <input type="hidden" name="comentarios[{{ $document['campo'] }}]" class="comentario-hidden" data-id="{{ $document['id'] }}">
    <input type="hidden" name="estados[{{ $document['campo'] }}]" class="estado-hidden" data-id="{{ $document['id'] }}" value="pending">
</tr>
@endforeach
</tbody>

          </table>
        </div>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-success btn-lg" onclick="beforeSubmit()">
            <i class="fas fa-check"></i> Finalizar Revisión
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

@include('layouts.footer')

<script>

    document.querySelectorAll('.approve-checkbox, .reject-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const documentId = checkbox.dataset.documentId;
            const approve = document.querySelector(`.approve-checkbox[data-document-id="${documentId}"]`);
            const reject = document.querySelector(`.reject-checkbox[data-document-id="${documentId}"]`);

            // Desmarcar el otro si uno se marca
            if (checkbox.classList.contains('approve-checkbox') && checkbox.checked) {
                reject.checked = false;
            } else if (checkbox.classList.contains('reject-checkbox') && checkbox.checked) {
                approve.checked = false;
            }

            // Determinar estado
            let estado = 'pending';
            if (approve.checked) estado = 'approved';
            if (reject.checked) estado = 'rejected';

            // Actualizar input oculto
            document.querySelector(`.estado-hidden[data-id="${documentId}"]`).value = estado;

            // Cambiar clase de la fila
            const row = document.querySelector(`tr[data-document-id="${documentId}"]`);
            row.classList.remove('document-approved', 'document-rejected', 'document-pending');

            if (estado === 'approved') {
                row.classList.add('document-approved');
            } else if (estado === 'rejected') {
                row.classList.add('document-rejected');
            } else {
                row.classList.add('document-pending');
            }

            // Actualizar ícono visual
            const status = row.querySelector('.status-indicator');
            status.classList.remove('approved', 'rejected');
            status.innerHTML = ''; // Limpiar ícono

            if (estado === 'approved') {
                status.classList.add('approved');
                status.innerHTML = '<i class="fas fa-check-circle"></i>';
            } else if (estado === 'rejected') {
                status.classList.add('rejected');
                status.innerHTML = '<i class="fas fa-times-circle"></i>';
            } else {
                status.innerHTML = '<i class="fas fa-clock text-warning"></i>';
            }
        });
    });


function updateDocumentStatus(id, action, checked) {
  const row = document.querySelector(`[data-document-id="${id}"]`);
  const approve = row.querySelector('.approve-checkbox');
  const reject = row.querySelector('.reject-checkbox');
  const status = document.getElementById(`status-${id}`);
  const estadoInput = row.querySelector('.estado-hidden');

  if (action === 'approve' && checked) {
    reject.checked = false;
    status.innerHTML = '<i class="fas fa-check-circle text-success"></i>';
    estadoInput.value = 'aprobado';
  } else if (action === 'reject' && checked) {
    approve.checked = false;
    status.innerHTML = '<i class="fas fa-times-circle text-danger"></i>';
    estadoInput.value = 'rechazado';
  } else {
    status.innerHTML = '<i class="fas fa-clock text-warning"></i>';
    estadoInput.value = 'pendiente';
  }
}

document.querySelectorAll('.approve-checkbox').forEach(cb => {
  cb.addEventListener('change', () => {
    updateDocumentStatus(cb.dataset.documentId, 'approve', cb.checked);
  });
});

document.querySelectorAll('.reject-checkbox').forEach(cb => {
  cb.addEventListener('change', () => {
    updateDocumentStatus(cb.dataset.documentId, 'reject', cb.checked);
  });
});

document.querySelectorAll('.comment-textarea').forEach(textarea => {
  textarea.addEventListener('input', () => {
    const id = textarea.dataset.documentId;
    const inputHidden = document.querySelector(`.comentario-hidden[data-id="${id}"]`);
    inputHidden.value = textarea.value;
  });
});

function beforeSubmit() {
  document.querySelectorAll('.document-row').forEach(row => {
    const id = row.dataset.documentId;
    const estadoInput = document.querySelector(`.estado-hidden[data-id="${id}"]`);
    const comentarioInput = document.querySelector(`.comentario-hidden[data-id="${id}"]`);
    const aprobado = row.querySelector('.approve-checkbox').checked;
    const rechazado = row.querySelector('.reject-checkbox').checked;
    let estado = 'pendiente';
    if (aprobado) estado = 'aprobado';
    if (rechazado) estado = 'rechazado';
    estadoInput.value = estado;
    comentarioInput.value = row.querySelector('.comment-textarea').value;
  });
}
</script>
@endsection
