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
                                    ['label' => 'REGISTRADO POR', 'class' => 'text-center'],
                                    ['label' => 'EQUIPO', 'class' => 'w-25'],
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
                                                <div class="mb-1">
                                                    <span class="info-label">Nombre:</span>
                                                    <span class="info-value">{{ $return->user->Name }}</span><br />
                                                </div>
                                                <div class="mb-1">
                                                    <span class="info-label">DNI:</span>
                                                    <span class="info-value">{{ $return->user->Document }}</span><br />
                                                </div>
                                                <div class="mb-1">
                                                    <span class="info-label">Email:</span>
                                                    <span class="info-value">{{ $return->user->Email }}</span><br />
                                                </div>
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
        $estados = [
            1 => ['nombre' => 'Disponible',      'icono' => 'fa-circle-check',         'color' => 'success'],
            2 => ['nombre' => 'Por preparar',    'icono' => 'fa-hourglass-half',       'color' => 'info'],
            3 => ['nombre' => 'En uso',          'icono' => 'fa-laptop',               'color' => 'primary'],
            4 => ['nombre' => 'Observación',     'icono' => 'fa-eye',                  'color' => 'warning'],
            5 => ['nombre' => 'R Pendiente',     'icono' => 'fa-tools',                'color' => 'secondary'],
            6 => ['nombre' => 'No devuelto',     'icono' => 'fa-exclamation-triangle', 'color' => 'danger'],
            7 => ['nombre' => 'Perdida-Robo',    'icono' => 'fa-shield-alt',           'color' => 'dark'],
            8 => ['nombre' => 'De baja',         'icono' => 'fa-ban',                  'color' => 'secondary'],
        ];

        $estado = $estados[$return->Status] ?? [
            'nombre' => 'Desconocido',
            'icono'  => 'fa-question-circle',
            'color'  => 'secondary'
        ];
    @endphp

    <span class="badge bg-{{ $estado['color'] }}">
        <i class="fa-solid {{ $estado['icono'] }} me-1"></i>
        {{ $estado['nombre'] }}
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

                                                <div class="col-12">
                                                    <div class="alert alert-info">
                                                        <small>
                                                            <strong>Información del equipo:</strong><br>
                                                            Equipo: {{ $return->equipment->CodigoPatri ?? 'N/A' }} -
                                                            {{ $return->equipment->equipmentType->Name ?? 'N/A' }}<br>
                                                            Asignado a: {{ $return->assignment->user->Name ?? 'N/A' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            <form action="{{ route('devolucion.update', $return->id) }}" method="POST"
                                                enctype="multipart/form-data" id="formEditar{{ $return->id }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="row"> <!-- ← AGREGADO -->

                                                    <div class="col-md-6 pt-2">
                                                        <label class="form-label fw-semibold">
                                                            Fecha:
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="datetime-local" name="Date" class="form-control"
                                                            value="{{ $return->Date->format('Y-m-d\TH:i') }}" required>
                                                    </div>

                                                    <div class="col-md-6 pt-2">
                                                        <label class="form-label fw-semibold">
                                                            Estado del equipo:
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="estado" class="form-control selectpicker" data-size="5" data-live-search="true" required>
                                                            <option value="1"
                                                                {{ $return->Status == 1 ? 'selected' : '' }}>Disponible
                                                            </option>
                                                            <option value="2"
                                                                {{ $return->Status == 2 ? 'selected' : '' }}>Por preparar
                                                            </option>
                                                            <option value="4"
                                                                {{ $return->Status == 4 ? 'selected' : '' }}>Observación
                                                            </option>
                                                            <option value="5"
                                                                {{ $return->Status == 5 ? 'selected' : '' }}>R Pendiente
                                                            </option>
                                                            <option value="6"
                                                                {{ $return->Status == 6 ? 'selected' : '' }}>No devuelto
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 pt-2">
                                                        <label class="form-label fw-semibold">Comentario:</label>
                                                        <textarea name="comentario" class="form-control" rows="3" placeholder="Observaciones sobre la devolución">{{ $return->Comment }}</textarea>
                                                    </div>

                                                    <div class="col-md-6 pt-2">
                                                        <label class="form-label fw-semibold">Imagen:</label>
                                                        <input class="form-control" type="file" name="imagen"
                                                            accept="image/jpeg,image/png,image/jpg">

                                                        @if ($return->Image)
                                                            <small class="text-success">
                                                                <i class="fa-solid fa-image"></i>
                                                                <a href="{{ Storage::disk('public')->url($return->Image) }}"
                                                                    target="_blank" class="text-decoration-none">Ver imagen
                                                                    actual</a>
                                                            </small>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6 pt-2">
                                                        <label class="form-label fw-semibold">Documento:<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="file" name="documento"
                                                            accept=".pdf">

                                                        @if ($return->Document)
                                                            <small class="text-success">
                                                                <i class="fa-solid fa-file"></i>
                                                                <a href="{{ Storage::disk('public')->url($return->Document) }}"
                                                                    target="_blank" class="text-decoration-none">Ver documento
                                                                    actual</a>
                                                            </small>
                                                        @endif
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
