@extends('template')
@section('title', 'Historial')

@push('css')
    <link href="{{ asset('Css/historial.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        @can('Historial-Inventario')
            <div class="col-12 pt-4">
                <div class="card shadow-sm border-0">
                    <x-card-header title="HISTORIAL DE EQUIPOS" icon="fa-solid fa-computer">

                        <form action="{{ route('inventario.historial') }}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-semibold" for="codigo">
                                        Codigo patrimonial:
                                    </label>
                                    <input type="text" class="form-control" id="codigo" name="codigo"
                                        placeholder="Escribe codigo patrimonial" 
                                        value="{{ request('codigo') }}">
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-semibold" for="serie">
                                        Serie:
                                    </label>
                                    <input type="text" class="form-control" id="serie" name="serie"
                                        placeholder="Escribir serie" 
                                        value="{{ request('serie') }}">
                                </div>
                                <div class="col-12 col-md-4 col-lg-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if(request()->has('codigo') || request()->has('serie'))
                            @if($equipment)
                                <!-- Información del Equipo -->
                                <div class="row pt-3">
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <div class="info-item text-center">
                                            <div class="info-circle mx-auto mb-2">
                                                <i class="fa-solid fa-laptop text-secondary"></i>
                                            </div>
                                            <div class="info-label">{{ $equipment->equipmentType->Name ?? 'N/A' }}</div>
                                            <div class="info-value">TIPO</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <div class="info-item text-center">
                                            <div class="info-circle mx-auto mb-2">
                                                <i class="fa-solid fa-hashtag text-secondary"></i>
                                            </div>
                                            <div class="info-label text-truncate" title="{{ $equipment->CodigoPatri }}">
                                                {{ $equipment->CodigoPatri }}
                                            </div>
                                            <div class="info-value">CÓDIGO PATRIMONIAL</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <div class="info-item text-center">
                                            <div class="info-circle mx-auto mb-2">
                                                <i class="fa-solid fa-barcode text-secondary"></i>
                                            </div>
                                            <div class="info-label text-truncate" title="{{ $equipment->Series }}">
                                                {{ $equipment->Series }}
                                            </div>
                                            <div class="info-value">SERIE</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <div class="info-item text-center">
                                            <div class="info-circle mx-auto mb-2">
                                                <i class="fa-solid fa-desktop text-secondary"></i>
                                            </div>
                                            <div class="info-label">{{ $equipment->Model }}</div>
                                            <div class="info-value">MODELO</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <div class="info-item text-center">
                                            <div class="info-circle mx-auto mb-2">
                                                <i class="fa-solid fa-user text-secondary"></i>
                                            </div>
                                            <div class="info-label">{{ $equipment->supplier->Company_name ?? 'N/A' }}</div>
                                            <div class="info-value">PROVEEDOR</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <div class="info-item text-center">
                                            <div class="info-circle mx-auto mb-2">
                                                <i class="fa-solid fa-tag text-secondary"></i>
                                            </div>
                                            <div class="info-label">{{ $equipment->Brand }}</div>
                                            <div class="info-value">MARCA</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <div class="info-item text-center">
                                            <div class="info-circle mx-auto mb-2">
                                                <i class="fa-solid fa-dollar-sign text-secondary"></i>
                                            </div>
                                            <div class="info-label">S/ {{ number_format($equipment->Price, 2) }}</div>
                                            <div class="info-value">PRECIO</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <div class="info-item text-center">
                                            <span class="badge bg-{{ $equipment->status_class }} mb-2">
                                                <i class="fa-solid {{ $equipment->status_icon }} me-1"></i>
                                                {{ $equipment->status_text }}
                                            </span>
                                            <div class="info-value">ESTADO</div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <button class="btn btn-primary btn-circle action-btn" title="Ver descripción"
                                                data-bs-toggle="modal" data-bs-target="#descripcionModal">
                                                <i class="fa-solid fa-file-lines"></i>
                                            </button>
                                            @if($equipment->Imagen)
                                                <button class="btn btn-dark btn-circle action-btn" title="Ver imágenes"
                                                    data-bs-toggle="modal" data-bs-target="#imagenModal">
                                                    <i class="fa-solid fa-images"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Historial de Asignaciones y Devoluciones -->
                                <div class="row pt-2">
                                    @forelse($historial as $registro)
                                        <div class="col-12 col-lg-6 col-xl-4 mb-3">
                                            <div class="card h-100" id="card">
                                                <h6 class="card-header text-center" id="encabezado">
                                                    REGISTRO #{{ $loop->iteration }}
                                                </h6>
                                                <div class="card-body fondocard">
                                                    <div class="row">
                                                        <!-- Asignación -->
                                                        <div class="col-12 col-sm-6">
                                                            <h6 class="text-primary mb-2">
                                                                <i class="fa-solid fa-laptop me-1"></i>ASIGNACIÓN
                                                            </h6>
                                                            <span class="info-span d-block mb-2">
                                                                <i class="fa-solid fa-user"></i>&nbsp;USUARIO: 
                                                                {{ $registro['asignacion']->user->Name ?? 'N/A' }}
                                                            </span>
                                                            <span class="info-span d-block mb-2">
                                                                <i class="fa-solid fa-calendar-days"></i>&nbsp;FECHA DE ENTREGA:
                                                                {{ $registro['asignacion']->Date ? $registro['asignacion']->Date->format('d/m/Y H:i:s') : 'N/A' }}
                                                            </span>
                                                            <span class="info-span d-block mb-2">
                                                                <i class="fa-solid fa-location-dot"></i>&nbsp;
                                                                {{ $registro['asignacion']->boss->Name ?? 'N/A' }}
                                                                <br/>{{ $registro['asignacion']->boss->area->Name ?? 'N/A' }}
                                                            </span>
                                                            <span class="info-span d-block mb-2">
                                                                ESTADO: 
                                                                @if($registro['estado_asignacion'] == 1)
                                                                    <span class="badge bg-success">
                                                                        <i class="fa-solid fa-circle-check me-1"></i>Activa
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-secondary">
                                                                        <i class="fa-solid fa-circle-xmark me-1"></i>Inactiva
                                                                    </span>
                                                                @endif
                                                            </span>
                                                            <div class="pt-2 d-flex gap-2 flex-wrap">
                                                                @if($registro['asignacion']->Document)
                                                                    <a href="{{ asset('storage/' . $registro['asignacion']->Document) }}" 
                                                                       target="_blank" 
                                                                       class="btn btn-primary btn-circle action-btn" 
                                                                       title="Ver Documento">
                                                                        <i class="fa-solid fa-file-lines"></i>
                                                                    </a>
                                                                @endif
                                                                @if($registro['asignacion']->Image)
                                                                    <a href="{{ asset('storage/' . $registro['asignacion']->Image) }}" 
                                                                       target="_blank" 
                                                                       class="btn btn-dark btn-circle action-btn" 
                                                                       title="Ver imágenes">
                                                                        <i class="fa-solid fa-images"></i>
                                                                    </a>
                                                                @endif
                                                                @if($registro['asignacion']->Comment)
                                                                    <button class="btn btn-danger btn-circle action-btn" 
                                                                            title="Ver comentario"
                                                                            data-bs-toggle="modal" 
                                                                            data-bs-target="#comentarioAsignacion{{ $registro['asignacion']->idAssignment }}">
                                                                        <i class="fa-solid fa-message"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Devolución -->
                                                        <div class="col-12 col-sm-6">
                                                            <h6 class="text-info mb-2">
                                                                <i class="fa-solid fa-rotate-left me-1"></i>DEVOLUCIÓN
                                                                @if($registro['devolucion'] && $registro['estado_devolucion'] == 0)
                                                                    <span class="badge bg-secondary ms-1">Inactiva</span>
                                                                @endif
                                                            </h6>
                                                            @if($registro['devolucion'])
                                                                <span class="info-span d-block mb-2">
                                                                    <i class="fa-solid fa-user"></i>&nbsp;USUARIO: 
                                                                    {{ $registro['devolucion']->user->Name ?? 'N/A' }}
                                                                </span>
                                                                <span class="info-span d-block mb-2">
                                                                    <i class="fa-solid fa-calendar-days"></i>&nbsp;FECHA DE DEVOLUCION:
                                                                    {{ $registro['devolucion']->Date ? $registro['devolucion']->Date->format('d/m/Y H:i:s') : 'N/A' }}
                                                                </span>
                                                                <span class="info-span d-block mb-2">
                                                                    <i class="fa-solid fa-repeat"></i>&nbsp;ESTADO: 
                                                                    @if($registro['estado_devolucion'] == 1)
                                                                        <span class="badge bg-success">Completada</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">Inactiva</span>
                                                                    @endif
                                                                </span>
                                                                <div class="pt-2 d-flex gap-2 flex-wrap">
                                                                    @if($registro['devolucion']->Comment)
                                                                        <button class="btn btn-info btn-circle action-btn" 
                                                                                title="Ver Motivo"
                                                                                data-bs-toggle="modal" 
                                                                                data-bs-target="#comentarioDevolucion{{ $registro['devolucion']->id }}">
                                                                            <i class="fa-solid fa-hand-holding"></i>
                                                                        </button>
                                                                    @endif
                                                                    @if($registro['devolucion']->Document)
                                                                        <a href="{{ asset('storage/' . $registro['devolucion']->Document) }}" 
                                                                           target="_blank" 
                                                                           class="btn btn-primary btn-circle action-btn" 
                                                                           title="Ver Documento">
                                                                            <i class="fa-solid fa-file-lines"></i>
                                                                        </a>
                                                                    @endif
                                                                    @if($registro['devolucion']->Image)
                                                                        <a href="{{ asset('storage/' . $registro['devolucion']->Image) }}" 
                                                                           target="_blank" 
                                                                           class="btn btn-dark btn-circle action-btn" 
                                                                           title="Ver imágenes">
                                                                            <i class="fa-solid fa-images"></i>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div class="text-center text-muted py-3">
                                                                    <i class="fa-solid fa-clock fa-2x mb-2"></i>
                                                                    <p>Sin devolución registrada</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($registro['asignacion']->Comment)
                                            <div class="modal fade" id="comentarioAsignacion{{ $registro['asignacion']->idAssignment }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header" id="header">
                                                            <h5 class="modal-title">Comentario de Asignación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ $registro['asignacion']->Comment }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($registro['devolucion'] && $registro['devolucion']->Comment)
                                            <div class="modal fade" id="comentarioDevolucion{{ $registro['devolucion']->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Comentario de Devolución</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ $registro['devolucion']->Comment }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-info text-center">
                                                <i class="fa-solid fa-info-circle me-2"></i>
                                                No se encontraron registros de asignaciones para este equipo.
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            @else
                                <div class="alert alert-warning mt-3 text-center">
                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                    No se encontró ningún equipo con los criterios de búsqueda proporcionados.
                                </div>
                            @endif
                        @endif

                    </x-card-header>
                </div>
            </div>

            @if(isset($equipment))
            <div class="modal fade" id="descripcionModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Descripción del Equipo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>{{ $equipment->Description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($equipment->Imagen)
            <div class="modal fade" id="imagenModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Imagen del Equipo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ asset('storage/' . $equipment->Imagen) }}" 
                                 alt="Imagen de {{ $equipment->CodigoPatri }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 500px;">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endif

        @endcan
    </div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Historial cargado correctamente');
    });
</script>
@endpush