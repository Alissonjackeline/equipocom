@extends('template')
@section('title', 'Crear asignacion')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
@include('layouts.partials.alert')
<div class="container-fluid">
    <div class="row pt-3">
        <x-card-header 
            title="CREAR ASIGNACION" 
            icon="fa-solid fa-file-circle-plus">

            <form action="{{ route('asignacion.store') }}" method="POST" enctype="multipart/form-data" id="assignmentForm">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="Date">
                            Fecha de entrega:
                            <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control" id="Date" name="Date" 
                               value="{{ old('Date', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('Date')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="User_id">
                            Usuario:
                            <span class="text-danger">*</span>
                        </label>
                       @if (auth()->check() && auth()->user())
    <input type="number" name="User_id" id="User_id" class="form-control" readonly
        value="{{ auth()->user()->idUser }}">
@endif

                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="Boss_id">
                            Jefe que autoriza:
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-control selectpicker" data-size="5" data-live-search="true" 
                                id="Boss_id" name="Boss_id" required>
                            <option value="" selected disabled>Seleccionar jefe</option>
                            @foreach($bosses as $boss)
                                <option value="{{ $boss->idBoss }}" {{ old('Boss_id') == $boss->idBoss ? 'selected' : '' }}>
                                    {{ $boss->Document }} - {{ $boss->Name }} ({{ $boss->Cargo }})
                                </option>
                            @endforeach
                        </select>
                        @error('Boss_id')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="equipment_search">
                            Buscar por serie o codigo patrimonial:
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="equipment_search" 
                                   placeholder="Ingrese código patrimonial o serie">
                            <button type="button" class="btn btn-secondary" id="searchButton">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                        <small class="text-muted">Solo se mostrarán equipos disponibles (Estado: Disponible)</small>
                        <small class="text-info d-block mt-1">
                            <i class="fa-solid fa-lightbulb"></i> Deje vacío y presione buscar para ver todos los equipos disponibles
                        </small>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Equipos a asignar: <span class="text-danger">*</span></label>
                        <div id="selected_equipments" class="border rounded p-3 bg-light">
                            <p class="text-muted mb-0">No hay equipos seleccionados. Use la búsqueda para agregar equipos.</p>
                        </div>
                        
                        <div id="equipment_inputs">
                            @if(old('equipments'))
                                @foreach(old('equipments') as $equipmentId)
                                    <input type="hidden" name="equipments[]" value="{{ $equipmentId }}">
                                @endforeach
                            @endif
                        </div>
                        
                        @error('equipments')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="Comment">
                            Comentario:
                        </label>
                        <textarea class="form-control" id="Comment" name="Comment" rows="3" 
                                  placeholder="Observaciones o comentarios sobre la asignación">{{ old('Comment') }}</textarea>
                        @error('Comment')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="Document">
                            Documento: <span class="text-danger">*</span>
                        </label>
                        <input class="form-control" type="file" id="Document" name="Document" 
                               accept=".pdf">
                        <small class="text-muted">Formatos: PDF (Max: 2MB)</small>
                        @error('Document')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="Image">
                            Imagen:
                        </label>
                        <input class="form-control" type="file" id="Image" name="Image" 
                               accept="image/jpeg,image/png,image/jpg">
                        <small class="text-muted">Formatos: JPG, PNG (Max: 2MB)</small>
                        @error('Image')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end pt-3">
                    <a href="{{ route('asignacion.index') }}" class="btn btn-secondary mx-2">CANCELAR</a>
                    <button class="btn btn-primary mx-2" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i> GUARDAR ASIGNACIÓN
                    </button>
                </div>
            </form>
            
        </x-card-header>
    </div>
</div>

<div class="modal fade" id="equipmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Equipos Disponibles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="equipmentResults">
                <p class="text-muted">Realice una búsqueda para ver los equipos disponibles.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    let selectedEquipments = @json(old('equipments', []));
    let equipmentData = {};

    async function loadSelectedEquipmentsData() {
        if (selectedEquipments.length === 0) return;

        try {
            const response = await fetch(`{{ route('asignacion.search-equipment') }}?search=&get_selected=true&ids=${selectedEquipments.join(',')}`);
            if (response.ok) {
                const data = await response.json();
                data.forEach(equipment => {
                    equipmentData[equipment.idEquipment] = equipment;
                });
                updateSelectedEquipmentsDisplay();
            }
        } catch (error) {
            console.error('Error cargando datos de equipos:', error);
        }
    }

    function searchEquipment() {
        const search = document.getElementById('equipment_search').value.trim();
        
        // Mostrar loading
        const resultsDiv = document.getElementById('equipmentResults');
        resultsDiv.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"></div><p class="mt-2">Buscando equipos disponibles...</p></div>';

        let url = `{{ route('asignacion.search-equipment') }}?search=${encodeURIComponent(search)}`;
        
        if (selectedEquipments.length > 0) {
            url += `&include_selected=true`;
        }

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
                            <small>Verifique el código patrimonial o serie e intente nuevamente.</small>
                        </div>
                    `;
                } else {
                    let html = '<div class="list-group">';
                    data.forEach(equipment => {
                        equipmentData[equipment.idEquipment] = equipment;
                        
                        const isSelected = selectedEquipments.includes(equipment.idEquipment.toString());
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
                                    </div>
                                    <button type="button" class="btn ${isSelected ? 'btn-danger' : 'btn-success'} ms-3" 
                                            onclick="toggleEquipment(${equipment.idEquipment})">
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
                
                const modal = new bootstrap.Modal(document.getElementById('equipmentModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                resultsDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                        Error al buscar equipos: ${error.message}
                    </div>
                `;
                const modal = new bootstrap.Modal(document.getElementById('equipmentModal'));
                modal.show();
            });
    }

    function toggleEquipment(equipmentId) {
        const index = selectedEquipments.indexOf(equipmentId.toString());
        
        if (index === -1) {
            selectedEquipments.push(equipmentId.toString());
        } else {
            selectedEquipments.splice(index, 1);
        }

        updateSelectedEquipmentsDisplay();
        updateEquipmentInputs();
        
        const button = event.target;
        if (index === -1) {
            button.classList.remove('btn-success');
            button.classList.add('btn-danger');
            button.innerHTML = '<i class="fa-solid fa-minus"></i> Quitar';
        } else {
            button.classList.remove('btn-danger');
            button.classList.add('btn-success');
            button.innerHTML = '<i class="fa-solid fa-plus"></i> Agregar';
        }
    }

    function updateSelectedEquipmentsDisplay() {
        const container = document.getElementById('selected_equipments');
        
        if (selectedEquipments.length === 0) {
            container.innerHTML = '<p class="text-muted mb-0">No hay equipos seleccionados. Use la búsqueda para agregar equipos.</p>';
            return;
        }

        let html = '<div class="row">';
        selectedEquipments.forEach((equipmentId, index) => {
            const equipment = equipmentData[equipmentId];
            if (equipment) {
                html += `
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card border-success">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-1">${equipment.Brand} ${equipment.Model}</h6>
                                        <p class="card-text mb-1 small">
                                            <strong>Código:</strong> ${equipment.CodigoPatri}
                                        </p>
                                        <p class="card-text mb-0 small">
                                            <strong>Serie:</strong> ${equipment.Series}
                                        </p>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="removeEquipment(${equipmentId})"
                                            title="Quitar equipo">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                html += `
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card border-warning">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-1">Equipo #${equipmentId}</h6>
                                        <p class="card-text mb-0 small text-muted">
                                            Cargando información...
                                        </p>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="removeEquipment(${equipmentId})"
                                            title="Quitar equipo">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        });
        html += '</div>';
        container.innerHTML = html;
    }

    function updateEquipmentInputs() {
        const container = document.getElementById('equipment_inputs');
        container.innerHTML = ''; 
        selectedEquipments.forEach(equipmentId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'equipments[]';
            input.value = equipmentId;
            container.appendChild(input);
        });
    }

    function removeEquipment(equipmentId) {
        const index = selectedEquipments.indexOf(equipmentId.toString());
        if (index !== -1) {
            selectedEquipments.splice(index, 1);
            updateSelectedEquipmentsDisplay();
            updateEquipmentInputs();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        $('.selectpicker').selectpicker();
        
        document.getElementById('searchButton').addEventListener('click', searchEquipment);
        
        document.getElementById('equipment_search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchEquipment();
            }
        });
        
        if (selectedEquipments.length > 0) {
            loadSelectedEquipmentsData();
        } else {
            updateSelectedEquipmentsDisplay();
        }
        updateEquipmentInputs();
    });
</script>
@endpush