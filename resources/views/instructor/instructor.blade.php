@extends('layouts.header')
@section ('title', 'Documentación certificación Etapa productiva')
@section ('titleHeader', 'Documentación certificación Etapa productiva')
    <link href="{{ asset('css/portal.css') }}" rel="stylesheet">
@section('content')

<section class="page-section portfolio" id="quienes_somos">
  <div class="container" bis_skin_checked="1">
    <div class="portal-container">
        <div class="status-container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card stat-total">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ count($students) }}</h3>
                            <p>Total Estudiantes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-approved">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ collect($students)->where('status', 'approved')->count() }}</h3>
                            <p>Aprobados</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-pending">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ collect($students)->where('status', 'pending')->count() }}</h3>
                            <p>Pendientes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-revision">
                        <div class="stat-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ collect($students)->where('status', 'revision')->count() }}</h3>
                            <p>En Revisión</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table instructor-table">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Documento</th>
                        <th>Programa</th>
                        <th>Fecha Envío</th>
                        <th>Progreso</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>
                            <div class="student-info">
                                <strong>{{ $student['name'] }}</strong>
                            </div>
                        </td>
                        <td>{{ $student['document'] }}</td>
                        <td>
                            <small class="text-muted">{{ $student['program'] }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($student['submitted_at'])->format('d/m/Y') }}</td>
                        <td>
                            <div class="progress-container">
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" style="width: {{ ($student['approved_docs'] / $student['total_docs']) * 100 }}%"></div>
                                    <div class="progress-bar bg-danger" style="width: {{ ($student['rejected_docs'] / $student['total_docs']) * 100 }}%"></div>
                                </div>
                                <small class="progress-text">
                                    {{ $student['approved_docs'] }}/{{ $student['total_docs'] }} aprobados
                                </small>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $student['status'] }}">
                                @if($student['status'] == 'approved')
                                    <i class="fas fa-check-circle"></i> Aprobado
                                @elseif($student['status'] == 'pending')
                                    <i class="fas fa-clock"></i> Pendiente
                                @else
                                    <i class="fas fa-exclamation-triangle"></i> Revisión
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('instructor.review', $student['id']) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Revisar
                                </a>
                                <button class="btn btn-info btn-sm" onclick="sendNotification({{ $student['id'] }})">
                                    <i class="fas fa-envelope"></i> Notificar
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@include('layouts.footer')

<script>
function sendNotification(studentId) {
    if (confirm('¿Enviar notificación al estudiante?')) {
        alert('Notificación enviada correctamente (simulación)');
    }
}
</script>
@endsection
