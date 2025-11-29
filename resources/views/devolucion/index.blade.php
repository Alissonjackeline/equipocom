@extends('template')
@section('title', 'Devoluciones')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')
    <div class="container-fluid">
        @can('Ver-Devolucion')
            <div class="col-12 pt-4">
                <div class="card shadow-sm border-0">
                    <x-card-header title="LISTAR DE DEVOLUCIONES" icon="fa-solid fa-file-circle-plus">

                        <div class="row pt-3">
                            <div class="col-lg-12">
                                <x-data-table :columns="[
                                    ['label' => 'ID°', 'class' => 'text-center'],
                                    ['label' => 'FECHA DEVOLUCION'],
                                    ['label' => 'EQUIPO', 'class' => 'w-25'],
                                    ['label' => 'MOTIVO', 'class' => 'text-center'],
                                    ['label' => 'DOCUMENTO/IMAGEN/COMENTARIO', 'class' => 'text-center'],
                                    ['label' => 'ESTADO', 'class' => 'text-center'],
                                    ['label' => 'ACCIONES', 'class' => 'text-center'],
                                ]" table-id="example">

                                    @foreach ($returns as $return)
                                        <tr>
                                            <td>
                                                <div class="info-label text-center">{{ $return->id }}</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info text-white">
                                                    {{ $return->Date->format('d/m/Y H:i:s') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($return->equipment)
                                                    <div class="mb-1">
                                                        <span class="info-label">Tipo</span>
                                                        <span
                                                            class="info-value">{{ $return->equipment->equipmentType->Name ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="info-label">Código Patrimonial</span>
                                                        <span class="info-value">{{ $return->equipment->CodigoPatri }}</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="info-label">Serie</span>
                                                        <span class="info-value">{{ $return->equipment->Series }}</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="info-label">Modelo</span>
                                                        <span class="info-value">{{ $return->equipment->Model }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="info-label">Marca</span>
                                                        <span class="info-value">{{ $return->equipment->Brand }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Equipo no encontrado</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($return->Comment)
                                                    <span title="{{ $return->Comment }}">
                                                        {{ Str::limit($return->Comment, 50) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Sin comentario</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($return->Document)
                                                    <button class="btn btn-primary btn-circle action-btn" data-bs-toggle="modal"
                                                        data-bs-target="#modalDocu{{ $return->id }}" title="Ver Documento">
                                                        <i class="fa-solid fa-file-lines"></i>
                                                    </button>
                                                @endif

                                                @if ($return->Image)
                                                    <button class="btn btn-dark btn-circle action-btn" title="Ver imágenes"
                                                        data-bs-toggle="modal" data-bs-target="#modalImg{{ $return->id }}">
                                                        <i class="fa-solid fa-images"></i>
                                                    </button>
                                                @endif

                                                @if ($return->Comment)
                                                    <button class="btn btn-danger btn-circle action-btn" title="Ver comentario"
                                                        data-bs-toggle="modal" data-bs-target="#modalCom{{ $return->id }}">
                                                        <i class="fa-solid fa-message"></i>
                                                    </button>
                                                @endif

                                                @if (!$return->Document && !$return->Image && !$return->Comment)
                                                    <span class="text-muted small">Sin archivos</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $estadoText = match ($return->Status ?? 0) {
                                                        1 => 'Disponible',
                                                        2 => 'Por preparar',
                                                        3 => 'En uso',
                                                        4 => 'Observación',
                                                        5 => 'R Pendiente',
                                                        6 => 'No devuelto',
                                                        default => 'Desconocido',
                                                    };
                                                    $estadoColor = match ($return->Status ?? 0) {
                                                        1 => 'success',
                                                        2 => 'warning',
                                                        3 => 'info',
                                                        4 => 'danger',
                                                        5 => 'warning',
                                                        6 => 'danger',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $estadoColor }}">
                                                    <i class="fa-solid fa-lightbulb"></i>&nbsp;{{ $estadoText }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    @can('Editar-Devolucion')
                                                        <button class="btn btn-warning btn-sm action-btn" title="Editar"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalEditar{{ $return->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                    @endcan
                                                    @can('Eliminar-Devolucion')
                                                        <button class="btn btn-danger btn-sm action-btn" title="Eliminar"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalEliminar{{ $return->id }}">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        <x-modal-base id="modalEditar{{ $return->id }}"
                                            title="Editar Devolución ID {{ $return->id }}" size="modal-lg"
                                            formId="formEditar{{ $return->id }}">

                                            <form action="{{ route('devolucion.update', $return->id) }}" method="POST"
                                                enctype="multipart/form-data" class="row"
                                                id="formEditar{{ $return->id }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="col-md-12 pt-2">
                                                    <label class="form-label fw-semibold">
                                                        Fecha:
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="datetime-local" name="Date" class="form-control"
                                                        value="{{ $return->Date->format('Y-m-d\TH:i') }}" required>
                                                </div>

                                                <div class="col-md-12 pt-2">
                                                    <label class="form-label fw-semibold">
                                                        Estado del equipo:
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select name="estado" class="form-select" required>
                                                        <option value="1" {{ $return->Status == 1 ? 'selected' : '' }}>
                                                            Disponible</option>
                                                        <option value="2" {{ $return->Status == 2 ? 'selected' : '' }}>Por
                                                            preparar</option>
                                                        <option value="4" {{ $return->Status == 4 ? 'selected' : '' }}>
                                                            Observación</option>
                                                        <option value="5" {{ $return->Status == 5 ? 'selected' : '' }}>R
                                                            Pendiente</option>
                                                        <option value="6" {{ $return->Status == 6 ? 'selected' : '' }}>No
                                                            devuelto</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-12 pt-2">
                                                    <label class="form-label fw-semibold">
                                                        Comentario:
                                                    </label>
                                                    <textarea name="comentario" class="form-control" rows="3" placeholder="Observaciones sobre la devolución">{{ $return->Comment }}</textarea>
                                                </div>

                                                <div class="col-md-6 pt-2">
                                                    <label class="form-label fw-semibold">
                                                        Imagen:
                                                    </label>
                                                    <input class="form-control" type="file" name="imagen"
                                                        accept="image/jpeg,image/png,image/jpg">
                                                    @if ($return->Image)
                                                        <small class="text-success">
                                                            <i class="fa-solid fa-image"></i>
                                                            <a href="{{ Storage::disk('public')->url($return->Image) }}"
                                                                target="_blank" class="text-decoration-none">
                                                                Ver imagen actual
                                                            </a>
                                                        </small>
                                                    @endif
                                                </div>

                                                <div class="col-md-6 pt-2">
                                                    <label class="form-label fw-semibold">
                                                        Documento:
                                                    </label>
                                                    <input class="form-control" type="file" name="documento"
                                                        accept=".pdf">
                                                    @if ($return->Document)
                                                        <small class="text-success">
                                                            <i class="fa-solid fa-file"></i>
                                                            <a href="{{ Storage::disk('public')->url($return->Document) }}"
                                                                target="_blank" class="text-decoration-none">
                                                                Ver documento actual
                                                            </a>
                                                        </small>
                                                    @endif
                                                </div>

                                                <div class="col-12 pt-3">
                                                    <div class="alert alert-info">
                                                        <small>
                                                            <strong>Información del equipo:</strong><br>
                                                            Equipo: {{ $return->equipment->CodigoPatri ?? 'N/A' }} -
                                                            {{ $return->equipment->equipmentType->Name ?? 'N/A' }}<br>
                                                            Asignado a: {{ $return->assignment->user->Name ?? 'N/A' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </form>
                                        </x-modal-base>
                                        <div class="modal fade" id="modalEliminar{{ $return->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Eliminar Devolución</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Está seguro de eliminar esta devolución?</p>
                                                        <p><strong>Equipo:</strong>
                                                            {{ $return->equipment->CodigoPatri ?? 'N/A' }}
                                                        </p>
                                                        <p><strong>Fecha:</strong> {{ $return->Date->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancelar</button>
                                                        <form action="{{ route('devolucion.destroy', $return->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($return->Document)
                                            <x-btn-documento id="modalDocu{{ $return->id }}"
                                                title="DOCUMENTO - Devolución #{{ $return->id }}" size="modal-lg">
                                                <embed src="{{ asset('storage/' . $return->Document) }}"
                                                    type="application/pdf" width="100%" height="500px" />
                                            </x-btn-documento>
                                        @endif

                                        @if ($return->Image)
                                            <x-btn-imagen id="modalImg{{ $return->id }}"
                                                title="IMAGEN - Devolución #{{ $return->id }}" size="modal-lg">
                                                <img src="{{ asset('storage/' . $return->Image) }}" class="img-fluid"
                                                    alt="Imagen de la devolución">
                                            </x-btn-imagen>
                                        @endif

                                        @if ($return->Comment)
                                            <x-btn-descripcion id="modalCom{{ $return->id }}"
                                                title="COMENTARIO - Devolución #{{ $return->id }}" size="modal-md">
                                                <p class="text-justify">{{ $return->Comment }}</p>
                                            </x-btn-descripcion>
                                        @endif
                                    @endforeach

                                </x-data-table>
                            </div>
                        </div>

                    </x-card-header>
                </div>
            </div>
        @endcan
    </div>
@endsection

@push('js')
@endpush
