@extends('layouts.app')

@section('title', 'Portal CEET - Dashboard Instructor')

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
                <p class="header-subtitle">Regional Distrito Capital - Dashboard Instructor</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="hero-image">
                    <span>Panel<br>Instructor<br>CEET</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="portal-container">
        <div class="portal-header">
            <h2 class="portal-title">DASHBOARD INSTRUCTOR - REVISIÓN DE DOCUMENTOS</h2>
            <p class="portal-subtitle">Gestión y revisión de documentos de estudiantes</p>
        </div>

        <div class="stats-container">
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
function sendNotification(studentId) {
    if (confirm('¿Enviar notificación al estudiante?')) {
        alert('Notificación enviada correctamente (simulación)');
    }
}
</script>
@endsection
