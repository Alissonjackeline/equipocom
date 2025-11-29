@extends('template')
@section('title', 'Panel')

@section('content')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '<h2 style="color: #4CAF50; font-weight: bold;">¡Bienvenido, {{ session('success') }}!</h2>',
                    html: `<p style="font-size: 1.1em; color: #333;">Sistema de Asignacion de equipos</p>`,
                    icon: "success",
                    showConfirmButton: true,
                    timer: 5000,
                    timerProgressBar: true,
                    background: 'linear-gradient(to right, #e0f7fa, #ffffff)',
                    padding: '1.5em',
                });
            });
        </script>
    @endif
    
    <div class="container-fluid">
        <div class="row pt-1">
            <div class="col-12 col-md-12">
                <div class="row">
                    <x-card 
                        icon="fa-solid fa-users" 
                        title="TOTAL DE USUARIOS" 
                        value="{{ $stats['total_usuarios'] }}" 
                        bgColor="bg-primary" 
                    />
                    <x-card 
                        icon="fa-solid fa-laptop" 
                        title="TOTAL DE EQUIPOS" 
                        value="{{ $stats['total_equipos'] }}" 
                        bgColor="bg-success" 
                    />
                    <x-card 
                        icon="fa-solid fa-user-tie" 
                        title="TOTAL DE JEFES" 
                        value="{{ $stats['total_jefes'] }}" 
                        bgColor="bg-info" 
                    />
                    <x-card 
                        icon="fa-solid fa-building" 
                        title="TOTAL DE ÁREAS" 
                        value="{{ $stats['total_areas'] }}" 
                        bgColor="bg-warning" 
                    />
                    <x-card 
                        icon="fa-solid fa-truck" 
                        title="PROVEEDORES" 
                        value="{{ $stats['total_proveedores'] }}" 
                        bgColor="bg-secondary" 
                    />
                    <x-card 
                        icon="fa-solid fa-computer" 
                        title="TIPOS DE EQUIPO" 
                        value="{{ $stats['total_tipos_equipo'] }}" 
                        bgColor="bg-dark" 
                    />
                    <x-card 
                        icon="fa-solid fa-circle-check" 
                        title="EQUIPOS DISPONIBLES" 
                        value="{{ $stats['equipos_disponibles'] }}" 
                        bgColor="bg-success" 
                    />
                    <x-card 
                        icon="fa-solid fa-laptop-code" 
                        title="EQUIPOS ASIGNADOS" 
                        value="{{ $stats['equipos_asignados'] }}" 
                        bgColor="bg-primary" 
                    />
                </div>
            </div>

            <div class="col-12 col-md-6 pt-2">
                <div class="card">
                    <h5 class="card-header text-center" id="encabezado">
                        <i class="fa-solid fa-chart-pie"></i>&nbsp;Estados de Equipos
                    </h5>
                    <div class="card-body" id="card3">
                        <canvas id="estadosEquiposChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 pt-2">
                <div class="card">
                    <h5 class="card-header text-center" id="encabezado">
                        <i class="fa-solid fa-file-circle-plus"></i>&nbsp;Asignaciones recientes
                    </h5>
                    <div class="card-body p-3" id="card3">
                        @forelse($asignaciones_recientes as $asignacion)
                            <div class="border-bottom pb-2 mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $asignacion->user->Name ?? 'N/A' }}</strong>
                                        <small class="d-block text-muted">
                                            {{ $asignacion->boss->area->Name ?? 'N/A' }}
                                        </small>
                                        <small class="text-muted">
                                            {{ $asignacion->Date->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-primary">
                                        {{ $asignacion->assignedTeams->count() }} equipo(s)
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center">No hay asignaciones recientes</p>
                        @endforelse
                    
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 pt-2">
                <div class="card" id="card1">
                    <h5 class="card-header text-center" id="encabezado">
                        <i class="fa-solid fa-repeat"></i>&nbsp;Devoluciones recientes
                    </h5>
                    <div class="card-body p-3" id="card3">
                        @forelse($devoluciones_recientes as $devolucion)
                            <div class="border-bottom pb-2 mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $devolucion->equipment->CodigoPatri ?? 'N/A' }}</strong>
                                        <small class="d-block text-muted">
                                            Registrado por: {{ $devolucion->user->Name ?? 'N/A' }}
                                        </small>
                                        <small class="text-muted">
                                            {{ $devolucion->Date->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center">No hay devoluciones recientes</p>
                        @endforelse
                        
                        
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 pt-2">
                <div class="card" id="card1">
                    <h5 class="card-header text-center" id="encabezado">
                        <i class="fa-solid fa-chart-line"></i>&nbsp;Resumen de Actividad
                    </h5>
                    <div class="card-body p-3" id="card3">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="p-2 bg-light rounded">
                                    <h4 class="text-primary mb-1">{{ $asignaciones_recientes->count() }}</h4>
                                    <small class="text-muted">Asignaciones Hoy</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="p-2 bg-light rounded">
                                    <h4 class="text-success mb-1">{{ $devoluciones_recientes->count() }}</h4>
                                    <small class="text-muted">Devoluciones Hoy</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 bg-light rounded">
                                    <h4 class="text-info mb-1">{{ $stats['equipos_disponibles'] }}</h4>
                                    <small class="text-muted">Equipos Disponibles</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 bg-light rounded">
                                    <h4 class="text-warning mb-1">{{ $stats['equipos_asignados'] }}</h4>
                                    <small class="text-muted">Equipos en Uso</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('estadosEquiposChart').getContext('2d');
        const estadosEquiposChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Disponible', 
                    'Por Preparar', 
                    'En Uso', 
                    'Observación',
                    'R Pendiente',
                    'No Devuelto',
                    'Perdida/Robo',
                    'De Baja'
                ],
                datasets: [{
                    data: [
                        {{ $estados_equipos['disponible'] }},
                        {{ $estados_equipos['por_preparar'] }},
                        {{ $estados_equipos['en_uso'] }},
                        {{ $estados_equipos['observacion'] }},
                        {{ $estados_equipos['r_pendiente'] }},
                        {{ $estados_equipos['no_devuelto'] }},
                        {{ $estados_equipos['perdida_robo'] }},
                        {{ $estados_equipos['de_baja'] }}
                    ],
                    backgroundColor: [
                        '#28a745', // Disponible - Verde
                        '#17a2b8', // Por preparar - Azul claro
                        '#007bff', // En uso - Azul
                        '#ffc107', // Observación - Amarillo
                        '#6c757d', // R Pendiente - Gris
                        '#dc3545', // No devuelto - Rojo
                        '#343a40', // Perdida/Robo - Negro
                        '#6f42c1'  // De baja - Púrpura
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Distribución de Estados'
                    }
                }
            }
        });
    });
</script>
@endpush