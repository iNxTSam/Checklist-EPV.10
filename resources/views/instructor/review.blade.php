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
      </div>

      <form method="POST" action="{{ route('instructor.guardarRevision', $student['id']) }}">
        @csrf
        <input type="hidden" name="ficha" value="{{ request('ficha') }}">

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

                  <!-- Inputs ocultos -->
                  <input type="hidden" name="comentarios[{{ $document['campo'] }}]" class="comentario-hidden" data-id="{{ $document['id'] }}" value="{{ $document['comment'] }}">
                  <input type="hidden" name="estados[{{ $document['campo'] }}]" class="estado-hidden" data-id="{{ $document['id'] }}" value="{{ $document['approved'] ? 'approved' : ($document['rejected'] ? 'rejected' : 'pending') }}">
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        {{-- Verifica si hay al menos un archivo para mostrar el botón --}}
        @php
          $hayArchivos = collect($documents)->contains(function ($doc) {
              return !empty($doc['file_path']);
          });
        @endphp

        @if($hayArchivos)
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg" onclick="beforeSubmit()">
              <i class="fas fa-check"></i> Finalizar Revisión
            </button>
          </div>
        @endif
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

      if (checkbox.classList.contains('approve-checkbox') && checkbox.checked) {
        reject.checked = false;
      } else if (checkbox.classList.contains('reject-checkbox') && checkbox.checked) {
        approve.checked = false;
      }

      let estado = 'pending';
      if (approve.checked) estado = 'approved';
      else if (reject.checked) estado = 'rejected';

      document.querySelector(`.estado-hidden[data-id="${documentId}"]`).value = estado;

      const row = document.querySelector(`tr[data-document-id="${documentId}"]`);
      row.classList.remove('document-approved', 'document-rejected', 'document-pending');
      if (estado === 'approved') row.classList.add('document-approved');
      else if (estado === 'rejected') row.classList.add('document-rejected');
      else row.classList.add('document-pending');

      const status = row.querySelector('.status-indicator');
      status.classList.remove('approved', 'rejected');
      status.innerHTML = '';
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

      let estado = 'pending';
      if (aprobado) estado = 'approved';
      else if (rechazado) estado = 'rejected';

      estadoInput.value = estado;
      comentarioInput.value = row.querySelector('.comment-textarea').value;
    });
  }
</script>

@endsection
