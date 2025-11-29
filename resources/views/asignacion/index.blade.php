@extends('template')
@section('title', 'Asignaciones')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush
@section('content')
    @include('layouts.partials.alert')
    <div class="container-fluid">
        <div class="col-12 pt-4">
            <div class="card shadow-sm border-0">
                <x-card-header title="LISTAR ASIGNACIONES" icon="fa-solid fa-file-circle-plus">

                    <form action="{{ route('asignacion.index') }}" method="GET" class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label fw-semibold" for="desde">
                                Desde:
                            </label>
                            <input type="date" class="form-control" id="desde" name="desde"
                                value="{{ request('desde') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold" for="hasta">
                                Hasta:
                            </label>
                            <input type="date" class="form-control" id="hasta" name="hasta"
                                value="{{ request('hasta') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="usuario_id">
                                Usuario
                            </label>
                            <select class="form-control selectpicker" data-size="5" data-live-search="true" id="usuario_id"
                                name="usuario_id">
                                <option value="">Todos los usuarios</option>
                                @foreach ($users ?? [] as $user)
                                    <option value="{{ $user->idUser }}"
                                        {{ request('usuario_id') == $user->idUser ? 'selected' : '' }}>
                                        {{ $user->Name }} - {{ $user->Document }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="estado">
                                Estado
                            </label>
                            <select class="form-control selectpicker" data-size="5" data-live-search="true" id="estado"
                                name="estado">
                                <option value="">Todos los estados</option>
                                <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-primary me-2">
                                <i class="fa-solid fa-filter"></i> Filtrar
                            </button>
                            <a href="{{ route('asignacion.index') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-refresh"></i>
                            </a>
                        </div>
                    </form>

                </x-card-header>
            </div>
        </div>

        <div class="row pt-3">
            <div class="col-lg-12">
                <x-data-table :columns="[
                    ['label' => 'FECHA ASIGNACION', 'class' => 'text-center'],
                    ['label' => 'EQUIPOS ASIGNADOS', 'class' => 'text-center'],
                    ['label' => 'USUARIO ASIGNADO', 'class' => 'text-center'],
                    ['label' => 'JEFE AUTORIZADOR', 'class' => 'text-center'],
                    ['label' => 'DOCUMENTO/COMENTARIO/IMAGEN', 'class' => 'text-center'],
                    ['label' => 'ACCIONES', 'class' => 'text-center'],
                ]" table-id="example">

                    @foreach ($assignments as $assignment)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-info text-white">
                                    {{ $assignment->Date->format('d/m/Y H:i') }}
                                </span>
                            </td>
                            <td>
                                @foreach ($assignment->assignedTeams as $assignedTeam)
                                    <div class="mb-2 p-2 border rounded bg-light">
                                        <div class="mb-1">
                                            <span class="info-label">Tipo</span>
                                            <span
                                                class="info-value">{{ $assignedTeam->equipment->equipmentType->Name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span class="info-label">Código Patrimonial</span>
                                            <span class="info-value">{{ $assignedTeam->equipment->CodigoPatri }}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span class="info-label">Serie</span>
                                            <span class="info-value">{{ $assignedTeam->equipment->Series }}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span class="info-label">Modelo</span>
                                            <span class="info-value">{{ $assignedTeam->equipment->Model }}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span class="info-label">Marca</span>
                                            <span class="info-value">{{ $assignedTeam->equipment->Brand }}</span>
                                        </div>
                                        <div>
                                            <span class="info-label">Estado</span>
                                            <span class="badge {{ $assignedTeam->Status ? 'bg-success' : 'bg-danger' }}">
                                                <i
                                                    class="fa-solid {{ $assignedTeam->Status ? 'fa-circle-check' : 'fa-circle-xmark' }} me-1"></i>
                                                {{ $assignedTeam->Status ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <div class="mb-1">
                                    <span class="info-label">Nombre:</span>
                                    <span class="info-value">{{ $assignment->user->Name }}</span><br />
                                </div>
                                <div class="mb-1">
                                    <span class="info-label">DNI:</span>
                                    <span class="info-value">{{ $assignment->user->Document }}</span><br />
                                </div>
                                <div class="mb-1">
                                    <span class="info-label">Email:</span>
                                    <span class="info-value">{{ $assignment->user->Email }}</span><br />
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="mb-1">
                                    <span class="info-asigtable">{{ $assignment->boss->Name }}</span><br />
                                    <span class="info-asigtable">DNI: {{ $assignment->boss->Document }}</span><br />
                                    <span class="info-asigtable text-muted small">
                                        {{ $assignment->boss->Cargo }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-center">
                                @if ($assignment->Document)
                                    <button class="btn btn-primary btn-circle action-btn" data-bs-toggle="modal"
                                        data-bs-target="#modalDocu{{ $assignment->idAssignment }}" title="Ver Documento">
                                        <i class="fa-solid fa-file-lines"></i>
                                    </button>
                                @endif

                                @if ($assignment->Comment)
                                    <button class="btn btn-danger btn-circle action-btn" title="Ver descripción"
                                        data-bs-toggle="modal" data-bs-target="#modalDes{{ $assignment->idAssignment }}">
                                        <i class="fa-solid fa-message"></i>
                                    </button>
                                @endif

                                @if ($assignment->Image)
                                    <button class="btn btn-dark btn-circle action-btn" title="Ver imágenes"
                                        data-bs-toggle="modal" data-bs-target="#modalImg{{ $assignment->idAssignment }}">
                                        <i class="fa-solid fa-images"></i>
                                    </button>
                                @endif

                                @if (!$assignment->Document && !$assignment->Comment && !$assignment->Image)
                                    <span class="text-muted small">Sin archivos</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">

                                    @php
                                        $isActive = $assignment->assignedTeams->every(fn($t) => $t->Status == 1);
                                    @endphp

                                    @if ($isActive)
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEditar{{ $assignment->idAssignment }}" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEliminar{{ $assignment->idAssignment }}"
                                            title="Eliminar">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled title="No disponible">
                                            <i class="fa-solid fa-ban"></i>
                                        </button>
                                    @endif

                                </div>
                            </td>


                        </tr>
                    @endforeach

                </x-data-table>
            </div>
        </div>
    </div>
    </div>

    @foreach ($assignments as $assignment)
        <x-modal-base id="modalEditar{{ $assignment->idAssignment }}"
            title="Editar Asignación #{{ $assignment->idAssignment }}" size="modal-lg"
            formId="formEditar{{ $assignment->idAssignment }}">
            <form action="{{ route('asignacion.update', $assignment->idAssignment) }}" method="POST"
                enctype="multipart/form-data" id="formEditar{{ $assignment->idAssignment }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="Date{{ $assignment->idAssignment }}">
                            Fecha de entrega:
                            <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control" id="Date{{ $assignment->idAssignment }}"
                            name="Date" value="{{ old('Date', $assignment->Date->format('Y-m-d\TH:i')) }}" required>
                        @error('Date')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="User_id{{ $assignment->idAssignment }}">
                            Usuario:
                        </label>
                        <input type="text" class="form-control"
                            value="{{ $assignment->user->Document }} - {{ $assignment->user->Name }}" disabled>
                        <input type="hidden" name="User_id" value="{{ $assignment->user->idUser }}">
                        <small class="text-muted">El usuario no se puede modificar</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="Boss_id{{ $assignment->idAssignment }}">
                            Jefe que autoriza:
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-control selectpicker" data-size="5" data-live-search="true"
                            id="Boss_id{{ $assignment->idAssignment }}" name="Boss_id" required>
                            <option value="" disabled>Seleccionar jefe</option>
                            @foreach ($bosses as $boss)
                                <option value="{{ $boss->idBoss }}"
                                    {{ $assignment->Boss_id == $boss->idBoss ? 'selected' : '' }}>
                                    {{ $boss->Document }} - {{ $boss->Name }}
                                </option>
                            @endforeach
                        </select>
                        @error('Boss_id')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Estado de la asignación:
                        </label>
                        @php
                            $allActive = $assignment->assignedTeams->every(function ($assignedTeam) {
                                return $assignedTeam->Status == 1;
                            });
                        @endphp
                        <input type="text" class="form-control" value="{{ $allActive ? 'Activo' : 'Inactivo' }}"
                            disabled>
                        <small class="text-muted">El estado se basa en los equipos asignados</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="Comment{{ $assignment->idAssignment }}">
                            Comentario:
                        </label>
                        <textarea class="form-control" id="Comment{{ $assignment->idAssignment }}" name="Comment" rows="3"
                            placeholder="Observaciones o comentarios sobre la asignación">{{ old('Comment', $assignment->Comment) }}</textarea>
                        @error('Comment')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="Document{{ $assignment->idAssignment }}">
                            Documento:<span class="text-danger">*</span>
                        </label>
                        <input class="form-control" type="file" id="Document{{ $assignment->idAssignment }}"
                            name="Document" accept=".pdf,.doc,.docx">
                        <small class="text-muted">Formatos: PDF, DOC, DOCX (Max: 2MB)</small>
                        @if ($assignment->Document)
                            <div class="mt-1">
                                <small class="text-success">
                                    <i class="fa-solid fa-file"></i> Documento actual:
                                    <a href="{{ asset('storage/' . $assignment->Document) }}" target="_blank">Ver
                                        documento</a>
                                </small>
                            </div>
                        @endif
                        @error('Document')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="Image{{ $assignment->idAssignment }}">
                            Imagen:
                        </label>
                        <input class="form-control" type="file" id="Image{{ $assignment->idAssignment }}"
                            name="Image" accept="image/jpeg,image/png,image/jpg">
                        <small class="text-muted">Formatos: JPG, PNG (Max: 2MB)</small>
                        @if ($assignment->Image)
                            <div class="mt-1">
                                <small class="text-success">
                                    <i class="fa-solid fa-image"></i> Imagen actual disponible
                                </small>
                            </div>
                        @endif
                        @error('Image')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                </div>
            </form>
        </x-modal-base>
        <x-modal-delete-assignment id="modalEliminar{{ $assignment->idAssignment }}"
            assignmentId="{{ $assignment->idAssignment }}"
            action="{{ route('asignacion.destroy', $assignment->idAssignment) }}" />
        @if ($assignment->Document)
            <x-btn-documento id="modalDocu{{ $assignment->idAssignment }}"
                title="DOCUMENTO - Asignación #{{ $assignment->idAssignment }}" size="modal-lg">
                <embed src="{{ asset('storage/' . $assignment->Document) }}" type="application/pdf" width="100%"
                    height="600px" />
            </x-btn-documento>
        @endif

        @if ($assignment->Comment)
            <x-btn-descripcion id="modalDes{{ $assignment->idAssignment }}"
                title="COMENTARIO - Asignación #{{ $assignment->idAssignment }}" size="modal-md">
                <p class="text-justify">{{ $assignment->Comment }}</p>
            </x-btn-descripcion>
        @endif

        @if ($assignment->Image)
            <x-btn-imagen id="modalImg{{ $assignment->idAssignment }}"
                title="IMAGEN - Asignación #{{ $assignment->idAssignment }}" size="modal-lg">
                <img src="{{ asset('storage/' . $assignment->Image) }}" class="img-fluid" alt="Imagen de la asignación">
            </x-btn-imagen>
        @endif
    @endforeach

@endsection

@push('js')
@endpush
