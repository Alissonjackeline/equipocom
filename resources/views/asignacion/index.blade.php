@extends('template')
@section('title', 'Asignaciones')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
    <style>
        .equipos-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .equipo-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            background: #f8f9fa;
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .equipos-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                                <div class="equipos-grid">
                                    @foreach ($assignment->assignedTeams as $assignedTeam)
                                        <div class="equipo-card">
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
                                                <span
                                                    class="badge {{ $assignedTeam->Status ? 'bg-success' : 'bg-danger' }}">
                                                    <i
                                                        class="fa-solid {{ $assignedTeam->Status ? 'fa-circle-check' : 'fa-circle-xmark' }} me-1"></i>
                                                    {{ $assignedTeam->Status ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
                                    <x-btn-imagen id="modalImg{{ $assignment->idAssignment }}"
                                        title="IMAGEN - Asignación #{{ $assignment->idAssignment }}" size="modal-lg">
                                        <img src="{{ asset('storage/' . $assignment->Image) }}" class="img-fluid"
                                            alt="Imagen de la asignación">
                                    </x-btn-imagen>
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
                                        <x-modal-base id="modalEditar{{ $assignment->idAssignment }}"
                                            title="Editar Asignación #{{ $assignment->idAssignment }}" size="modal-lg"
                                            formId="formEditar{{ $assignment->idAssignment }}">
                                            <form action="{{ route('asignacion.update', $assignment->idAssignment) }}"
                                                method="POST" enctype="multipart/form-data"
                                                id="formEditar{{ $assignment->idAssignment }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold"
                                                            for="Date{{ $assignment->idAssignment }}">
                                                            Fecha de entrega:
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="datetime-local" class="form-control"
                                                            id="Date{{ $assignment->idAssignment }}" name="Date"
                                                            value="{{ old('Date', $assignment->Date->format('Y-m-d\TH:i')) }}"
                                                            required>
                                                        @error('Date')
                                                            <small class="text-danger">{{ '*' . $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold"
                                                            for="User_id{{ $assignment->idAssignment }}">
                                                            Usuario:
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $assignment->user->Document }} - {{ $assignment->user->Name }}"
                                                            disabled>
                                                        <input type="hidden" name="User_id"
                                                            value="{{ $assignment->user->idUser }}">
                                                        <small class="text-muted">El usuario no se puede modificar</small>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold"
                                                            for="Boss_id{{ $assignment->idAssignment }}">
                                                            Jefe que autoriza:
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-control selectpicker" data-size="5"
                                                            data-live-search="true"
                                                            id="Boss_id{{ $assignment->idAssignment }}" name="Boss_id"
                                                            required>
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
                                                            $allActive = $assignment->assignedTeams->every(function (
                                                                $assignedTeam,
                                                            ) {
                                                                return $assignedTeam->Status == 1;
                                                            });
                                                        @endphp
                                                        <input type="text" class="form-control"
                                                            value="{{ $allActive ? 'Activo' : 'Inactivo' }}" disabled>
                                                        <small class="text-muted">El estado se basa en los equipos
                                                            asignados</small>
                                                    </div>

                                                    <!-- SECCIÓN PARA GESTIONAR EQUIPOS -->
                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold">
                                                            Gestión de Equipos:
                                                        </label>

                                                        <!-- Equipos actuales -->
                                                        <div class="mb-3">
                                                            <h6 class="text-primary">Equipos actualmente asignados: <small
                                                                    class="text-muted">(Desactiva para eliminar de la
                                                                    asignación)</small></h6>
                                                            <div id="currentEquipments{{ $assignment->idAssignment }}"
                                                                class="border rounded p-3 bg-light">
                                                                @foreach ($assignment->assignedTeams as $assignedTeam)
                                                                    <div class="equipment-item mb-2 p-2 border rounded"
                                                                        id="equipmentItem{{ $assignedTeam->equipment->idEquipment }}">
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center">
                                                                            <div>
                                                                                <strong>{{ $assignedTeam->equipment->equipmentType->Name ?? 'N/A' }}</strong>
                                                                                <br>
                                                                                <small class="text-muted">
                                                                                    Código:
                                                                                    {{ $assignedTeam->equipment->CodigoPatri }}
                                                                                    |
                                                                                    Serie:
                                                                                    {{ $assignedTeam->equipment->Series }}
                                                                                    |
                                                                                    Marca:
                                                                                    {{ $assignedTeam->equipment->Brand }} |
                                                                                    Modelo:
                                                                                    {{ $assignedTeam->equipment->Model }}
                                                                                </small>
                                                                            </div>
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="form-check form-switch me-3">
                                                                                    <input
                                                                                        class="form-check-input equipment-status"
                                                                                        type="checkbox"
                                                                                        name="equipment_status[{{ $assignedTeam->equipment->idEquipment }}]"
                                                                                        value="1"
                                                                                        {{ $assignedTeam->Status ? 'checked' : '' }}
                                                                                        id="equipment{{ $assignedTeam->idAssignedTeam }}"
                                                                                        onchange="handleEquipmentStatusChange({{ $assignment->idAssignment }}, {{ $assignedTeam->equipment->idEquipment }}, this.checked)">
                                                                                    <label class="form-check-label"
                                                                                        for="equipment{{ $assignedTeam->idAssignedTeam }}">
                                                                                        {{ $assignedTeam->Status ? 'Activo' : 'Inactivo' }}
                                                                                    </label>
                                                                                </div>
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-outline-danger"
                                                                                    onclick="removeExistingEquipment({{ $assignment->idAssignment }}, {{ $assignedTeam->equipment->idEquipment }})"
                                                                                    title="Eliminar equipo de la asignación">
                                                                                    <i class="fa-solid fa-trash"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <!-- Inputs ocultos para equipos removidos -->
                                                        <div id="removedEquipmentInputs{{ $assignment->idAssignment }}">
                                                        </div>

                                                        <!-- Búsqueda y agregar nuevos equipos -->
                                                        <div class="mb-3">
                                                            <h6 class="text-success">Agregar nuevos equipos:</h6>
                                                            <div class="input-group mb-2">
                                                                <input type="text" class="form-control"
                                                                    id="equipmentSearch{{ $assignment->idAssignment }}"
                                                                    placeholder="Buscar por código patrimonial o serie">
                                                                <button type="button" class="btn btn-secondary"
                                                                    onclick="searchEquipmentForEdit({{ $assignment->idAssignment }})">
                                                                    <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                                                </button>
                                                            </div>
                                                            <small class="text-muted">Solo se mostrarán equipos
                                                                disponibles</small>
                                                        </div>

                                                        <!-- Equipos seleccionados para agregar -->
                                                        <div id="selectedNewEquipments{{ $assignment->idAssignment }}"
                                                            class="border rounded p-3 bg-light mb-3"
                                                            style="display: none;">
                                                            <h6 class="text-info">Equipos a agregar:</h6>
                                                            <div id="newEquipmentsList{{ $assignment->idAssignment }}">
                                                            </div>
                                                        </div>

                                                        <!-- Inputs ocultos para nuevos equipos -->
                                                        <div id="newEquipmentInputs{{ $assignment->idAssignment }}"></div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold"
                                                            for="Comment{{ $assignment->idAssignment }}">
                                                            Comentario:
                                                        </label>
                                                        <textarea class="form-control" id="Comment{{ $assignment->idAssignment }}" name="Comment" rows="3"
                                                            placeholder="Observaciones o comentarios sobre la asignación">{{ old('Comment', $assignment->Comment) }}</textarea>
                                                        @error('Comment')
                                                            <small class="text-danger">{{ '*' . $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold"
                                                            for="Document{{ $assignment->idAssignment }}">
                                                            Documento:
                                                        </label>
                                                        <input class="form-control" type="file"
                                                            id="Document{{ $assignment->idAssignment }}" name="Document"
                                                            accept=".pdf,.doc,.docx">
                                                        <small class="text-muted">Formatos: PDF, DOC, DOCX (Max:
                                                            2MB)</small>
                                                        @if ($assignment->Document)
                                                            <div class="mt-1">
                                                                <small class="text-success">
                                                                    <i class="fa-solid fa-file"></i> Documento actual:
                                                                    <a href="{{ asset('storage/' . $assignment->Document) }}"
                                                                        target="_blank">Ver
                                                                        documento</a>
                                                                </small>
                                                            </div>
                                                        @endif
                                                        @error('Document')
                                                            <small class="text-danger">{{ '*' . $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold"
                                                            for="Image{{ $assignment->idAssignment }}">
                                                            Imagen:
                                                        </label>
                                                        <input class="form-control" type="file"
                                                            id="Image{{ $assignment->idAssignment }}" name="Image"
                                                            accept="image/jpeg,image/png,image/jpg">
                                                        <small class="text-muted">Formatos: JPG, PNG (Max: 2MB)</small>
                                                        @if ($assignment->Image)
                                                            <div class="mt-1">
                                                                <small class="text-success">
                                                                    <i class="fa-solid fa-image"></i> Imagen actual
                                                                    disponible
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

                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEliminar{{ $assignment->idAssignment }}"
                                            title="Eliminar">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <x-modal-delete-assignment id="modalEliminar{{ $assignment->idAssignment }}"
                                            assignmentId="{{ $assignment->idAssignment }}"
                                            action="{{ route('asignacion.destroy', $assignment->idAssignment) }}" />
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled title="No disponible">
                                            <i class="fa-solid fa-ban"></i>
                                        </button>
                                    @endif
                                </div>
                                <div class="modal fade" id="equipmentModal{{ $assignment->idAssignment }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Equipos Disponibles</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body" id="equipmentResults{{ $assignment->idAssignment }}">
                                                <p class="text-muted">Realice una búsqueda para ver los equipos
                                                    disponibles.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @foreach ($assignments as $assignment)
                        @if ($assignment->Document)
                            <x-btn-documento id="modalDocu{{ $assignment->idAssignment }}"
                                title="DOCUMENTO - Asignación #{{ $assignment->idAssignment }}" size="modal-lg">
                                <embed src="{{ asset('storage/' . $assignment->Document) }}" type="application/pdf"
                                    width="100%" height="600px" />
                            </x-btn-documento>
                        @endif

                        @if ($assignment->Comment)
                            <x-btn-descripcion id="modalDes{{ $assignment->idAssignment }}"
                                title="COMENTARIO - Asignación #{{ $assignment->idAssignment }}" size="modal-md">
                                <p class="text-justify">{{ $assignment->Comment }}</p>
                            </x-btn-descripcion>
                        @endif
                    @endforeach


                </x-data-table>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        // Variables globales para cada modal de edición
        let selectedNewEquipments = {};
        let removedEquipments = {};
        let equipmentData = {};

        /**
         * Buscar equipos disponibles para edición
         */
        function searchEquipmentForEdit(assignmentId) {
            const search = document.getElementById('equipmentSearch' + assignmentId).value.trim();
            const resultsDiv = document.getElementById('equipmentResults' + assignmentId);

            // Mostrar loading
            resultsDiv.innerHTML =
                '<div class="text-center"><div class="spinner-border" role="status"></div><p class="mt-2">Buscando equipos disponibles...</p></div>';

            // Incluir el assignment_id en la búsqueda para excluir equipos ya asignados
            let url =
                `{{ route('asignacion.search-equipment') }}?search=${encodeURIComponent(search)}&assignment_id=${assignmentId}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.length === 0) {
                        resultsDiv.innerHTML = `
                        <div class="text-center text-muted">
                            <i class="fa-solid fa-search fa-2x mb-2"></i>
                            <p>No se encontraron equipos disponibles con ese criterio de búsqueda.</p>
                            <small>Intente con otro término o verifique que los equipos estén disponibles.</small>
                        </div>
                    `;
                    } else {
                        let html = '<div class="list-group">';
                        data.forEach(equipment => {
                            // Guardar datos del equipo
                            equipmentData[equipment.idEquipment] = equipment;

                            // Verificar si el equipo ya está seleccionado
                            const isSelected = selectedNewEquipments[assignmentId] &&
                                selectedNewEquipments[assignmentId].includes(equipment.idEquipment.toString());

                            html += `
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-primary">${equipment.Brand} ${equipment.Model}</h6>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1"><strong>Código Patrimonial:</strong> ${equipment.CodigoPatri}</p>
                                                <p class="mb-1"><strong>Serie:</strong> ${equipment.Series}</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><strong>Marca:</strong> ${equipment.Brand}</p>
                                                <p class="mb-1"><strong>Modelo:</strong> ${equipment.Model}</p>
                                            </div>
                                        </div>
                                        ${equipment.Description ? `<p class="mb-1"><strong>Descripción:</strong> ${equipment.Description}</p>` : ''}
                                        <small class="text-success">
                                            <i class="fa-solid fa-circle-check"></i> Disponible
                                        </small>
                                    </div>
                                    <button type="button" class="btn ${isSelected ? 'btn-danger' : 'btn-success'} ms-3" 
                                            onclick="toggleEquipmentForEdit(${assignmentId}, ${equipment.idEquipment})"
                                            title="${isSelected ? 'Quitar equipo' : 'Agregar equipo'}">
                                        ${isSelected ? 
                                            '<i class="fa-solid fa-minus"></i> Quitar' : 
                                            '<i class="fa-solid fa-plus"></i> Agregar'}
                                    </button>
                                </div>
                            </div>
                        `;
                        });
                        html += '</div>';

                        const searchInfo = search ?
                            `<p class="text-muted mb-3">Mostrando ${data.length} equipos disponibles que coinciden con "${search}"</p>` :
                            `<p class="text-muted mb-3">Mostrando todos los equipos disponibles (${data.length} equipos)</p>`;

                        resultsDiv.innerHTML = searchInfo + html;
                    }

                    // Mostrar el modal de resultados
                    const modal = new bootstrap.Modal(document.getElementById('equipmentModal' + assignmentId));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultsDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                        <strong>Error al buscar equipos:</strong> ${error.message}
                    </div>
                `;
                    const modal = new bootstrap.Modal(document.getElementById('equipmentModal' + assignmentId));
                    modal.show();
                });
        }

        /**
         * Alternar selección de equipo (agregar/quitar)
         */
        function toggleEquipmentForEdit(assignmentId, equipmentId) {
            // Inicializar array si no existe
            if (!selectedNewEquipments[assignmentId]) {
                selectedNewEquipments[assignmentId] = [];
            }

            const equipmentIdStr = equipmentId.toString();
            const index = selectedNewEquipments[assignmentId].indexOf(equipmentIdStr);

            if (index === -1) {
                // Agregar equipo
                selectedNewEquipments[assignmentId].push(equipmentIdStr);
                showToast('success', 'Equipo agregado', 'El equipo ha sido agregado a la lista de equipos a asignar.');
            } else {
                // Quitar equipo
                selectedNewEquipments[assignmentId].splice(index, 1);
                showToast('warning', 'Equipo removido', 'El equipo ha sido quitado de la lista de equipos a asignar.');
            }

            // Actualizar interfaz
            updateSelectedEquipmentsDisplay(assignmentId);
            updateNewEquipmentInputs(assignmentId);

            // Actualizar botón en el modal
            const button = event.target.closest('button');
            if (index === -1) {
                button.classList.remove('btn-success');
                button.classList.add('btn-danger');
                button.innerHTML = '<i class="fa-solid fa-minus"></i> Quitar';
                button.title = 'Quitar equipo';
            } else {
                button.classList.remove('btn-danger');
                button.classList.add('btn-success');
                button.innerHTML = '<i class="fa-solid fa-plus"></i> Agregar';
                button.title = 'Agregar equipo';
            }
        }

        /**
         * Actualizar visualización de equipos seleccionados para agregar
         */
        function updateSelectedEquipmentsDisplay(assignmentId) {
            const container = document.getElementById('selectedNewEquipments' + assignmentId);
            const listContainer = document.getElementById('newEquipmentsList' + assignmentId);

            if (!selectedNewEquipments[assignmentId] || selectedNewEquipments[assignmentId].length === 0) {
                container.style.display = 'none';
                return;
            }

            container.style.display = 'block';
            let html = '';

            selectedNewEquipments[assignmentId].forEach((equipmentId) => {
                const equipment = equipmentData[equipmentId];
                if (equipment) {
                    html += `
                    <div class="equipment-item mb-2 p-2 border rounded bg-light" id="newEquipmentItem${equipmentId}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="text-success">${equipment.Brand} ${equipment.Model}</strong>
                                <br>
                                <small class="text-muted">
                                    <i class="fa-solid fa-barcode"></i> Código: ${equipment.CodigoPatri} | 
                                    <i class="fa-solid fa-hashtag"></i> Serie: ${equipment.Series}
                                </small>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="removeEquipmentFromEdit(${assignmentId}, ${equipmentId})"
                                    title="Quitar equipo de la lista">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                } else {
                    // Si no tenemos los datos del equipo, mostrar información básica
                    html += `
                    <div class="equipment-item mb-2 p-2 border rounded bg-warning" id="newEquipmentItem${equipmentId}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Equipo #${equipmentId}</strong>
                                <br>
                                <small class="text-muted">
                                    <i class="fa-solid fa-info-circle"></i> Cargando información...
                                </small>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="removeEquipmentFromEdit(${assignmentId}, ${equipmentId})"
                                    title="Quitar equipo">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                }
            });

            listContainer.innerHTML = html;
        }

        /**
         * Actualizar inputs ocultos para nuevos equipos
         */
        function updateNewEquipmentInputs(assignmentId) {
            const container = document.getElementById('newEquipmentInputs' + assignmentId);

            // Limpiar container completamente
            container.innerHTML = '';

            if (selectedNewEquipments[assignmentId] && selectedNewEquipments[assignmentId].length > 0) {
                selectedNewEquipments[assignmentId].forEach(equipmentId => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'new_equipments[]';
                    input.value = equipmentId;
                    container.appendChild(input);
                });

                console.log(`Inputs creados para asignación ${assignmentId}:`, selectedNewEquipments[assignmentId]);
            }
        }

        /**
         * Remover equipo de la lista de equipos a agregar
         */
        function removeEquipmentFromEdit(assignmentId, equipmentId) {
            if (selectedNewEquipments[assignmentId]) {
                const index = selectedNewEquipments[assignmentId].indexOf(equipmentId.toString());
                if (index !== -1) {
                    selectedNewEquipments[assignmentId].splice(index, 1);
                    updateSelectedEquipmentsDisplay(assignmentId);
                    updateNewEquipmentInputs(assignmentId);
                    showToast('warning', 'Equipo removido', 'El equipo ha sido quitado de la lista de equipos a asignar.');
                }
            }
        }

        /**
         * Manejar cambio de estado en equipos existentes
         */
        function handleEquipmentStatusChange(assignmentId, equipmentId, isChecked) {
            if (!removedEquipments[assignmentId]) {
                removedEquipments[assignmentId] = [];
            }

            const equipmentIdStr = equipmentId.toString();
            const equipmentItem = document.getElementById('equipmentItem' + equipmentId);

            if (!isChecked) {
                // Si se desactiva, agregar a la lista de removidos
                if (!removedEquipments[assignmentId].includes(equipmentIdStr)) {
                    removedEquipments[assignmentId].push(equipmentIdStr);
                }

                // Cambiar apariencia visual
                if (equipmentItem) {
                    equipmentItem.style.opacity = '0.6';
                    equipmentItem.style.backgroundColor = '#f8d7da';
                    equipmentItem.style.borderColor = '#dc3545';
                }

                showToast('warning', 'Equipo marcado para remover',
                    'El equipo será eliminado de la asignación al guardar los cambios.');
            } else {
                // Si se reactiva, quitar de la lista de removidos
                const index = removedEquipments[assignmentId].indexOf(equipmentIdStr);
                if (index !== -1) {
                    removedEquipments[assignmentId].splice(index, 1);
                }

                // Restaurar apariencia normal
                if (equipmentItem) {
                    equipmentItem.style.opacity = '1';
                    equipmentItem.style.backgroundColor = '';
                    equipmentItem.style.borderColor = '';
                }

                showToast('success', 'Equipo reactivado', 'El equipo se mantendrá en la asignación.');
            }

            updateRemovedEquipmentInputs(assignmentId);
        }

        /**
         * Eliminar equipo existente de la asignación
         */
        function removeExistingEquipment(assignmentId, equipmentId) {
            if (!removedEquipments[assignmentId]) {
                removedEquipments[assignmentId] = [];
            }

            const equipmentIdStr = equipmentId.toString();

            // Agregar a la lista de removidos
            if (!removedEquipments[assignmentId].includes(equipmentIdStr)) {
                removedEquipments[assignmentId].push(equipmentIdStr);
            }

            // Ocultar completamente el elemento
            const equipmentItem = document.getElementById('equipmentItem' + equipmentId);
            if (equipmentItem) {
                equipmentItem.style.display = 'none';
            }

            // Desmarcar el checkbox si existe
            const checkbox = document.querySelector(`input[name="equipment_status[${equipmentId}]"]`);
            if (checkbox) {
                checkbox.checked = false;
            }

            updateRemovedEquipmentInputs(assignmentId);
            showToast('warning', 'Equipo eliminado', 'El equipo será removido de la asignación al guardar los cambios.');
        }

        /**
         * Actualizar inputs ocultos para equipos removidos
         */
        function updateRemovedEquipmentInputs(assignmentId) {
            const container = document.getElementById('removedEquipmentInputs' + assignmentId);
            container.innerHTML = '';

            if (removedEquipments[assignmentId] && removedEquipments[assignmentId].length > 0) {
                removedEquipments[assignmentId].forEach(equipmentId => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'removed_equipments[]';
                    input.value = equipmentId;
                    container.appendChild(input);
                });

                console.log(`Equipos removidos para asignación ${assignmentId}:`, removedEquipments[assignmentId]);
            }
        }

        /**
         * Mostrar notificación toast
         */
        function showToast(type, title, message) {
            // Crear contenedor de toasts si no existe
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '9999';
                document.body.appendChild(toastContainer);
            }

            // Crear toast
            const toastId = 'toast-' + Date.now();
            const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${title}</strong><br>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;

            toastContainer.insertAdjacentHTML('beforeend', toastHtml);

            // Mostrar toast
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, {
                delay: 3000
            });
            toast.show();

            // Remover toast del DOM después de ocultarse
            toastElement.addEventListener('hidden.bs.toast', function() {
                toastElement.remove();
            });
        }

        /**
         * DEBUG: Verificar datos antes de enviar el formulario
         */
        function debugFormData(assignmentId) {
            const form = document.getElementById('formEditar' + assignmentId);
            const formData = new FormData(form);

            console.log('=== DEBUG FORM DATA ===');
            console.log('Formulario:', form);
            console.log('Datos del formulario:');
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
            console.log('Equipos nuevos seleccionados:', selectedNewEquipments[assignmentId]);
            console.log('Equipos existentes a remover:', removedEquipments[assignmentId]);
            console.log('Contenedor de inputs nuevos:', document.getElementById('newEquipmentInputs' + assignmentId)
                .innerHTML);
            console.log('Contenedor de inputs removidos:', document.getElementById('removedEquipmentInputs' + assignmentId)
                .innerHTML);
            console.log('=== FIN DEBUG ===');
        }

        /**
         * Validar formulario antes de enviar
         */
        function validateForm(assignmentId) {
            const form = document.getElementById('formEditar' + assignmentId);
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            let errorMessage = '';

            // Validar campos requeridos
            for (let field of requiredFields) {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    errorMessage = 'Por favor, complete todos los campos requeridos.';
                } else {
                    field.classList.remove('is-invalid');
                }
            }

            // Validar que haya al menos un equipo (activo o nuevo)
            const activeEquipments = form.querySelectorAll('.equipment-status:checked').length;
            const newEquipments = selectedNewEquipments[assignmentId] ? selectedNewEquipments[assignmentId].length : 0;

            if (activeEquipments === 0 && newEquipments === 0) {
                isValid = false;
                errorMessage = 'Debe haber al menos un equipo asignado (activo o nuevo).';
                showToast('error', 'Error de validación', errorMessage);
            }

            if (!isValid && errorMessage) {
                showToast('error', 'Error de validación', errorMessage);
                return false;
            }

            return true;
        }

        /**
         * Limpiar búsqueda y selecciones
         */
        function clearSearch(assignmentId) {
            const searchInput = document.getElementById('equipmentSearch' + assignmentId);
            if (searchInput) {
                searchInput.value = '';
            }

            if (selectedNewEquipments[assignmentId]) {
                selectedNewEquipments[assignmentId] = [];
            }

            updateSelectedEquipmentsDisplay(assignmentId);
            updateNewEquipmentInputs(assignmentId);
        }

        // Inicializar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar selectpickers
            $('.selectpicker').selectpicker();

            // Inicializar arrays para cada asignación
            @foreach ($assignments as $assignment)
                selectedNewEquipments[{{ $assignment->idAssignment }}] = [];
                removedEquipments[{{ $assignment->idAssignment }}] = [];
            @endforeach

            // Agregar event listeners para los campos de búsqueda
            @foreach ($assignments as $assignment)
                const searchInput{{ $assignment->idAssignment }} = document.getElementById(
                    'equipmentSearch{{ $assignment->idAssignment }}');
                if (searchInput{{ $assignment->idAssignment }}) {
                    // Buscar con Enter
                    searchInput{{ $assignment->idAssignment }}.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            searchEquipmentForEdit({{ $assignment->idAssignment }});
                        }
                    });

                    // Limpiar búsqueda al cerrar el modal
                    const equipmentModal{{ $assignment->idAssignment }} = document.getElementById(
                        'equipmentModal{{ $assignment->idAssignment }}');
                    if (equipmentModal{{ $assignment->idAssignment }}) {
                        equipmentModal{{ $assignment->idAssignment }}.addEventListener('hidden.bs.modal',
                            function() {
                                // No limpiar la búsqueda para mantener la selección
                            });
                    }
                }

                // Agregar validación al formulario antes de enviar
                const form{{ $assignment->idAssignment }} = document.getElementById(
                    'formEditar{{ $assignment->idAssignment }}');
                if (form{{ $assignment->idAssignment }}) {
                    form{{ $assignment->idAssignment }}.addEventListener('submit', function(e) {
                        console.log('Formulario enviándose...');

                        // Validar formulario
                        if (!validateForm({{ $assignment->idAssignment }})) {
                            e.preventDefault();
                            return false;
                        }

                        // Debug información
                        debugFormData({{ $assignment->idAssignment }});

                        // Asegurarse de que todos los inputs estén actualizados
                        updateNewEquipmentInputs({{ $assignment->idAssignment }});
                        updateRemovedEquipmentInputs({{ $assignment->idAssignment }});

                        // Mostrar loading
                        const submitBtn = form{{ $assignment->idAssignment }}.querySelector(
                            'button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.innerHTML =
                                '<i class="fa-solid fa-spinner fa-spin me-1"></i> Actualizando...';
                            submitBtn.disabled = true;
                        }
                    });
                }

                // Reiniciar formulario cuando se cierre el modal
                const modal{{ $assignment->idAssignment }} = document.getElementById(
                    'modalEditar{{ $assignment->idAssignment }}');
                if (modal{{ $assignment->idAssignment }}) {
                    modal{{ $assignment->idAssignment }}.addEventListener('hidden.bs.modal', function() {
                        // No reiniciar las selecciones para permitir múltiples intentos
                        const submitBtn = form{{ $assignment->idAssignment }}.querySelector(
                            'button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> Actualizar';
                            submitBtn.disabled = false;
                        }
                    });
                }
            @endforeach

            // Agregar estilos CSS para mejor visualización
            const style = document.createElement('style');
            style.textContent = `
            .equipment-item {
                transition: all 0.3s ease;
            }
            .equipment-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            .toast {
                font-size: 0.875rem;
            }
            .is-invalid {
                border-color: #dc3545 !important;
            }
        `;
            document.head.appendChild(style);
        });

        // Hacer funciones disponibles globalmente para debugging
        window.debugAssignment = function(assignmentId) {
            debugFormData(assignmentId);
        };

        window.clearAssignmentSelections = function(assignmentId) {
            if (selectedNewEquipments[assignmentId]) {
                selectedNewEquipments[assignmentId] = [];
            }
            if (removedEquipments[assignmentId]) {
                removedEquipments[assignmentId] = [];
            }
            updateSelectedEquipmentsDisplay(assignmentId);
            updateNewEquipmentInputs(assignmentId);
            updateRemovedEquipmentInputs(assignmentId);
            showToast('info', 'Selecciones limpiadas', 'Todas las selecciones han sido reseteadas.');
        };
    </script>
@endpush
