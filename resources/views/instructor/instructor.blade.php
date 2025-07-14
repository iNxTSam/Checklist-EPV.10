@extends('layouts.header')
@section('title', 'Documentación certificación Etapa productiva')
@section('titleHeader', 'Documentación certificación Etapa productiva')
<link href="{{ asset('css/portal.css') }}" rel="stylesheet">
@section('content')

<section class="page-section portfolio">
  <div class="container">
    <div class="portal-container">

      <div class="status-container">
        <div class="row">
          <div class="col-md-3">
            <div class="stat-card stat-total">
              <div class="stat-icon">
                <i class="fas fa-users"></i>
              </div>
              <div class="stat-content">
                <h3>{{ $aprendices->count() }}</h3>
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
                <h3>{{ $aprendices->where('estado', 'Aprobado')->count() }}</h3>
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
                <h3>{{ $aprendices->where('estado', 'Pendiente')->count() }}</h3>
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
                <h3>{{ $aprendices->where('estado', 'Rechazado')->count() }}</h3>
                <p>Rechazados</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mb-4 text-end">
    <a href="{{ route('instructor.buscarFicha') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver a búsqueda de ficha
    </a>
      </div>


      <div class="table-responsive mt-4">
        <table class="table instructor-table">
          <thead>
            <tr>
              <th>Estudiante</th>
              <th>Documento</th>
              <th>Programa</th>
              <th>Ficha</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($aprendices as $aprendiz)
            <tr>
              <td><strong>{{ $aprendiz->Nombres }} {{ $aprendiz->Apellidos }}</strong></td>
              <td>{{ $aprendiz->idUsuarios }}</td>
              <td>Tecnólogo</td>
              <td>{{ $aprendiz->ficha->NumeroDeFicha ?? 'Sin ficha' }}</td>
              <td>
                <span class="status-badge status-{{ strtolower($aprendiz->estado) }}">
                  @if($aprendiz->estado === 'Aprobado')
                    <i class="fas fa-check-circle"></i> Aprobado
                  @elseif($aprendiz->estado === 'Pendiente')
                    <i class="fas fa-clock"></i> Pendiente
                  @else
                    <i class="fas fa-times-circle"></i> Rechazado
                  @endif
                </span>
              </td>
              <td>
                    <a href="{{ route('instructor.revision', ['id' => $aprendiz->idUsuarios, 'ficha' => request('ficha')]) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye"></i> Revisar
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center">No hay aprendices para mostrar.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</section>

@include('layouts.footer')
@endsection
