@extends('template')
@section('title', 'Crear devolucion')

@push('css')
    <link href="{{ asset('Css/historial.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')
    <div class="container-fluid">
        <div class="col-12 pt-4">
            <div class="card shadow-sm border-0">
                <x-card-header title="AGREGAR DEVOLUCION" icon="fa-solid fa-repeat">

                    <form id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" for="jefe_id">
                                    Jefe de Area:
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control selectpicker" data-size="5" data-live-search="true"
                                    id="jefe_id" name="jefe_id" required>
                                    <option value="" selected disabled>Seleccionar jefe de area</option>
                                    @foreach ($bosses as $boss)
                                        <option value="{{ $boss->idBoss }}">
                                            {{ $boss->Document }} - {{ $boss->Name }} ({{ $boss->Cargo }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-primary" id="filterButton">
                                    <i class="fa-solid fa-filter"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="card mt-3 d-none" id="assignedCard">
                        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2"
                            id="encabezado">
                            <h6 class="mb-0 flex-md-grow-1 text-center">DATOS DEL ASIGNADO</h6>
                        </div>
                        <div class="card-body fondocard">
                            <div class="row justify-content-center g-3" id="assignedData">
                            </div>
                        </div>
                    </div>
                    <div id="assignmentsContainer" class="mt-3">
                    </div>

                </x-card-header>
            </div>

            <div class="modal fade" id="devolverModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" id="encabezado">
                            <h5 class="modal-title">Registrar Devolución</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('devolucion.store') }}" method="POST" enctype="multipart/form-data"
                            id="returnForm">
                            @csrf
                            <input type="hidden" name="Assignment_id" id="modalAssignmentId">
                            <input type="hidden" name="Equipment_id" id="modalEquipmentId">
                            
                            
                            @if (auth()->check() && auth()->user())
                                <input type="hidden" name="User_id" id="modalUserId" value="{{ auth()->user()->idUser }}">
                            @endif

                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="modalDate">
                                            Fecha:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="datetime-local" class="form-control" id="modalDate" name="Date"
                                            value="{{ now()->format('Y-m-d\TH:i:s') }}" step="1" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="estado">
                                            Estado del equipo:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control selectpicker" data-size="5" data-live-search="true" name="estado" required>
                                            <option value="" selected disabled>Seleccionar estado</option>
                                            <option value="1">Disponible</option>
                                            <option value="2">Por preparar</option>
                                            <option value="4">Observación</option>
                                            <option value="5">R Pendiente</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="comentario">
                                            Comentario:
                                        </label>
                                        <textarea class="form-control" id="comentario" name="comentario" rows="3"
                                            placeholder="Observaciones sobre la devolución"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="imagen">
                                            Imagen:
                                        </label>
                                        <input class="form-control" type="file" id="imagen" name="imagen"
                                            accept="image/jpeg,image/png,image/jpg">
                                        <small class="text-muted">Formatos: JPG, PNG (Max: 2MB)</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="documento">
                                            Documento: <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" type="file" id="documento" name="documento"
                                            accept=".pdf">
                                        <small class="text-muted">Formatos: PDF (Max: 2MB)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-floppy-disk"></i> Guardar Devolución
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="dynamicModals"></div>

        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.selectpicker').selectpicker();

            document.getElementById('filterButton').addEventListener('click', function() {
                const bossId = document.getElementById('jefe_id').value;
                if (!bossId) {
                    alert('Por favor seleccione un jefe de área');
                    return;
                }
                loadBossAssignments(bossId);
            });

            function loadBossAssignments(bossId) {
                fetch(`/devolucion/boss-assignments/${bossId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Datos recibidos:', data);
                        if (data.boss) {
                            displayAssignedData(data.boss);
                        }
                        if (data.assignments) {
                            displayAssignments(data.assignments);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al cargar las asignaciones: ' + error.message);
                    });
            }

            function displayAssignedData(boss) {
                if (!boss) {
                    console.log('No hay datos del jefe');
                    return;
                }

                const assignedCard = document.getElementById('assignedCard');
                const assignedData = document.getElementById('assignedData');

                const documentNumber = boss.Document || 'N/A';
                const name = boss.Name || 'N/A';
                const cargo = boss.Cargo || 'N/A';
                const phone = boss.Phone || 'N/A';
                const areaName = boss.area?.Name || 'N/A';
                const sedeName = boss.area?.headquarters?.Name || 'N/A';

                assignedData.innerHTML = `
                <!-- DNI -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="info-item text-center">
                        <div class="info-circle mx-auto mb-2">
                            <i class="fa-solid fa-address-card text-secondary"></i>
                        </div>
                        <div class="info-label small">${documentNumber}</div>
                        <div class="info-value small text-muted">DNI</div>
                    </div>
                </div>

                <!-- Nombre -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="info-item text-center">
                        <div class="info-circle mx-auto mb-2">
                            <i class="fa-solid fa-user-tag text-secondary"></i>
                        </div>
                        <div class="info-label small text-truncate" title="${name}">${name}</div>
                        <div class="info-value small text-muted">NOMBRE COMPLETO</div>
                    </div>
                </div>

                <!-- Cargo -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="info-item text-center">
                        <div class="info-circle mx-auto mb-2">
                            <i class="fa-solid fa-briefcase text-secondary"></i>
                        </div>
                        <div class="info-label small text-truncate" title="${cargo}">${cargo}</div>
                        <div class="info-value small text-muted">CARGO</div>
                    </div>
                </div>

                <!-- Teléfono -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="info-item text-center">
                        <div class="info-circle mx-auto mb-2">
                            <i class="fa-solid fa-phone text-secondary"></i>
                        </div>
                        <div class="info-label small">${phone}</div>
                        <div class="info-value small text-muted">TELÉFONO</div>
                    </div>
                </div>

                <!-- Área - Sede -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="info-item text-center">
                        <div class="info-circle mx-auto mb-2">
                            <i class="fa-solid fa-building text-secondary"></i>
                        </div>
                        <div class="info-label small text-truncate" title="${areaName}">
                            ${areaName}
                        </div>
                        <div class="info-label small text-truncate" title="${sedeName}">
                            ${sedeName}
                        </div>
                        <div class="info-value small text-muted">ÁREA - SEDE</div>
                    </div>
                </div>

                <!-- Estado -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="info-item text-center">
                        <span class="badge bg-success mb-2">
                            <i class="fa-solid fa-circle-check me-1"></i>Activo
                        </span>
                        <div class="info-value small text-muted">ESTADO</div>
                    </div>
                </div>
            `;

                assignedCard.classList.remove('d-none');
            }

            function displayAssignments(assignments) {
                const container = document.getElementById('assignmentsContainer');
                const dynamicModals = document.getElementById('dynamicModals');

                if (!assignments || assignments.length === 0) {
                    container.innerHTML =
                        '<div class="alert alert-info">No hay asignaciones activas para este jefe.</div>';
                    return;
                }

                let html = '';
                let modalsHtml = '';
                let modalCounter = 0;

                assignments.forEach(assignment => {
                    if (assignment.assigned_teams && assignment.assigned_teams.length > 0) {
                        assignment.assigned_teams.forEach(assignedTeam => {
                            const equipment = assignedTeam.equipment;
                            if (equipment) {
                                const modalId = `modal_${modalCounter++}`;

                                html += `
                                <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="card h-100" id="card">
                                        <h6 class="card-header text-center" id="encabezado">
                                            EQUIPO ASIGNADO
                                        </h6>
                                        <div class="card-body fondocard">
                                            <div class="row">
                                                <div class="col-12 col-sm-6">
                                                    <span class="info-span d-block mb-2">
                                                        <i class="fa-solid fa-user"></i>&nbsp;USUARIO: ${assignment.user?.Name || 'N/A'}
                                                    </span>
                                                    <span class="info-span d-block mb-2">
                                                        <i class="fa-solid fa-calendar-days"></i>&nbsp;FECHA DE ENTREGA: 
                                                        ${new Date(assignment.Date).toLocaleString()}
                                                    </span>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="pt-2 d-flex gap-2 flex-wrap justify-content-center justify-content-sm-start">
                                                        ${assignment.Document ? `
                                                                <button class="btn btn-primary btn-circle action-btn" 
                                                                        data-bs-toggle="modal" data-bs-target="#docModal_${modalId}" 
                                                                        title="Ver Documento">
                                                                    <i class="fa-solid fa-file-lines"></i>
                                                                </button>
                                                            ` : ''}
                                                        ${equipment.Description ? `
                                                                <button class="btn btn-danger btn-circle action-btn" 
                                                                        data-bs-toggle="modal" data-bs-target="#descModal_${modalId}" 
                                                                        title="Ver descripción">
                                                                    <i class="fa-solid fa-message"></i>
                                                                </button>
                                                            ` : ''}
                                                        ${equipment.Imagen ? `
                                                                <button class="btn btn-dark btn-circle action-btn" 
                                                                        data-bs-toggle="modal" data-bs-target="#imgModal_${modalId}" 
                                                                        title="Ver imágenes">
                                                                    <i class="fa-solid fa-images"></i>
                                                                </button>
                                                            ` : ''}
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <div class="row justify-content-center g-3">
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                            <div class="info-item text-center">
                                                                <div class="info-circle mx-auto mb-2">
                                                                    <i class="fa-solid fa-laptop text-secondary"></i>
                                                                </div>
                                                                <div class="info-label small">${equipment.equipment_type?.Name || 'N/A'}</div>
                                                                <div class="info-value small text-muted">TIPO</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                            <div class="info-item text-center">
                                                                <div class="info-circle mx-auto mb-2">
                                                                    <i class="fa-solid fa-hashtag text-secondary"></i>
                                                                </div>
                                                                <div class="info-label small text-truncate">${equipment.CodigoPatri || 'N/A'}</div>
                                                                <div class="info-value small text-muted">CÓDIGO PATRIMONIAL</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                            <div class="info-item text-center">
                                                                <div class="info-circle mx-auto mb-2">
                                                                    <i class="fa-solid fa-barcode text-secondary"></i>
                                                                </div>
                                                                <div class="info-label small text-truncate">${equipment.Series || 'N/A'}</div>
                                                                <div class="info-value small text-muted">SERIE</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                            <div class="info-item text-center">
                                                                <div class="info-circle mx-auto mb-2">
                                                                    <i class="fa-solid fa-desktop text-secondary"></i>
                                                                </div>
                                                                <div class="info-label small">${equipment.Model || 'N/A'}</div>
                                                                <div class="info-value small text-muted">MODELO</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                            <div class="info-item text-center">
                                                                <div class="info-circle mx-auto mb-2">
                                                                    <i class="fa-solid fa-user text-secondary"></i>
                                                                </div>
                                                                <div class="info-label small">${equipment.supplier?.Company_name || 'N/A'}</div>
                                                                <div class="info-value small text-muted">PROVEEDOR</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                            <div class="info-item text-center">
                                                                <div class="info-circle mx-auto mb-2">
                                                                    <i class="fa-solid fa-tag text-secondary"></i>
                                                                </div>
                                                                <div class="info-label small">${equipment.Brand || 'N/A'}</div>
                                                                <div class="info-value small text-muted">MARCA</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                            <div class="info-item text-center">
                                                                <div class="info-circle mx-auto mb-2">
                                                                    <i class="fa-solid fa-dollar-sign text-secondary"></i>
                                                                </div>
                                                                <div class="info-label small">S/ ${parseFloat(equipment.Price || 0).toFixed(2)}</div>
                                                                <div class="info-value small text-muted">PRECIO</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                            <div class="info-item text-center">
                                                                <span class="badge bg-success mb-2">
                                                                    <i class="fa-solid fa-circle-check me-1"></i>En uso
                                                                </span>
                                                                <div class="info-value small text-muted">ESTADO</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-3">
                                                        <button class="btn btn-primary" 
                                                                onclick="openReturnModal(${assignment.idAssignment}, ${equipment.idEquipment})">
                                                            <i class="fa-solid fa-repeat"></i> Devolver / Observar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                                if (assignment.Document) {
                                    modalsHtml += `
                                    <div class="modal fade" id="docModal_${modalId}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Documento - ${equipment.CodigoPatri || 'Equipo'}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <embed src="/storage/${assignment.Document}" type="application/pdf" width="100%" height="600px" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                }

                                if (equipment.Description) {
                                    modalsHtml += `
                                    <div class="modal fade" id="descModal_${modalId}" tabindex="-1">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header" id="encabezado">
                                                    <h5 class="modal-title">Descripción - ${equipment.CodigoPatri || 'Equipo'}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-justify">${equipment.Description}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                }

                                if (equipment.Imagen) {
                                    modalsHtml += `
                                    <div class="modal fade" id="imgModal_${modalId}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header" id="encabezado">
                                                    <h5 class="modal-title">Imagen - ${equipment.CodigoPatri || 'Equipo'}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="/storage/${equipment.Imagen}" class="img-fluid" alt="Imagen del equipo">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                }
                            }
                        });
                    }
                });

                container.innerHTML = html ? `<div class="row">${html}</div>` :
                    '<div class="alert alert-info">No hay equipos asignados activos.</div>';
                dynamicModals.innerHTML = modalsHtml;
            }

            window.openReturnModal = function(assignmentId, equipmentId) {
                document.getElementById('modalAssignmentId').value = assignmentId;
                document.getElementById('modalEquipmentId').value = equipmentId;

                const modal = new bootstrap.Modal(document.getElementById('devolverModal'));
                modal.show();
            };
        });
    </script>
@endpush