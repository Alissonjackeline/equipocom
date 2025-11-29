@extends('template')
@section('title', 'Jefes')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')

    <div class="container-fluid">
        <div class="row pt-2">
            <x-card-header title="JEFES" icon="fa-solid fa-id-card-clip">
                @can('Crear-Areas')
                <form action="{{ route('jefes.store') }}" method="POST" class="row g-3">
                    @csrf
                    
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            DNI:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Document" class="form-control @error('Document') is-invalid @enderror" 
                               placeholder="Ingrese DNI" value="{{ old('Document') }}" required maxlength="8">
                        @error('Document')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Nombre:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Name" class="form-control @error('Name') is-invalid @enderror" 
                               placeholder="Ingrese nombre" value="{{ old('Name') }}" required>
                        @error('Name')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Cargo:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Cargo" class="form-control @error('Cargo') is-invalid @enderror" 
                               placeholder="Ingrese cargo" value="{{ old('Cargo') }}" required>
                        @error('Cargo')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Teléfono:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Phone" class="form-control @error('Phone') is-invalid @enderror" 
                               placeholder="Ingrese teléfono" required value="{{ old('Phone') }}">
                        @error('Phone')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Área:<span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('Area_id') is-invalid @enderror" name="Area_id" required>
                            <option value="" disabled {{ old('Area_id') ? '' : 'selected' }}>Seleccionar área</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->idArea }}" 
                                    {{ old('Area_id') == $area->idArea ? 'selected' : '' }}>
                                    {{ $area->Name }}
                                </option>
                            @endforeach
                        </select>
                        @error('Area_id')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                        </button>
                    </div>
                </form>
                @else
                    <div class="alert alert-info text-center py-3">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        No tienes permisos para crear jefes
                    </div>
                @endcan
            </x-card-header>
        </div>

        <div class="row pt-3">
            <div class="col-lg-12">
                <x-data-table :columns="[
                    ['label' => 'DOCUMENTO'],
                    ['label' => 'NOMBRE'],
                    ['label' => 'CARGO'],
                    ['label' => 'TELÉFONO', 'class' => 'text-center'],
                    ['label' => 'ÁREA'],
                    ['label' => 'ESTADO', 'class' => 'text-center'],
                    ['label' => 'ACCIONES', 'class' => 'text-center'],
                ]" table-id="example">

                    @foreach ($bosses as $boss)
                        <tr>
                            <td>
                                <div class="info-label">{{ $boss->Document }}</div>
                            </td>
                            <td>
                                <div class="info-label">{{ $boss->Name }}</div>
                            </td>
                            <td>
                                <div class="info-label">{{ $boss->Cargo }}</div>
                            </td>
                            <td class="text-center">
                                <div class="info-label">{{ $boss->Phone ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div class="info-label">{{ $boss->area->Name ?? 'N/A' }}</div>
                            </td>
                            <td class="text-center">
                                @if ($boss->Status == 1)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @can('Editar-Areas')
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                        data-bs-target="#modalEditar{{ $boss->idBoss }}" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                @endcan
                                
                                @can('Estado-Areas')
                                    <button class="btn {{ $boss->Status == 1 ? 'btn-danger' : 'btn-success' }} btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEstado{{ $boss->idBoss }}"
                                        title="{{ $boss->Status == 1 ? 'Desactivar' : 'Activar' }}">
                                        <i class="fa-solid {{ $boss->Status == 1 ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>

                        <!-- Modal para cambiar estado -->
                        @can('Estado-Areas')
                            <x-modal-status 
                                id="modalEstado{{ $boss->idBoss }}"
                                message="¿Seguro que deseas {{ $boss->Status == 1 ? 'desactivar' : 'activar' }} al jefe '{{ $boss->Name }}'?"
                                action="{{ route('jefes.destroy', $boss->idBoss) }}"
                                confirmText="{{ $boss->Status == 1 ? 'Desactivar' : 'Activar' }}"
                                confirmClass="{{ $boss->Status == 1 ? 'btn-danger' : 'btn-success' }}"
                                method="DELETE" />
                        @endcan

                        <!-- Modal para editar -->
                        @can('Editar-Areas')
                            <x-modal-base id="modalEditar{{ $boss->idBoss }}" title="Editar Jefe: {{ $boss->Name }}" 
                                size="modal-md" formId="formEditar{{ $boss->idBoss }}">
                                <form action="{{ route('jefes.update', $boss->idBoss) }}" method="POST" 
                                    class="row g-3" id="formEditar{{ $boss->idBoss }}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            DNI:<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="Document" class="form-control @error('Document') is-invalid @enderror" 
                                               value="{{ old('Document', $boss->Document) }}" required maxlength="8">
                                        @error('Document')
                                            <small class="text-danger">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            Nombre:<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="Name" class="form-control @error('Name') is-invalid @enderror" 
                                               value="{{ old('Name', $boss->Name) }}" required>
                                        @error('Name')
                                            <small class="text-danger">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            Cargo:<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="Cargo" class="form-control @error('Cargo') is-invalid @enderror" 
                                               value="{{ old('Cargo', $boss->Cargo) }}" required>
                                        @error('Cargo')
                                            <small class="text-danger">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            Teléfono:<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="Phone" class="form-control @error('Phone') is-invalid @enderror" 
                                               value="{{ old('Phone', $boss->Phone) }}">
                                        @error('Phone')
                                            <small class="text-danger">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            Área:<span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('Area_id') is-invalid @enderror" name="Area_id" required>
                                            <option value="" disabled>Seleccionar área</option>
                                            @foreach($areas as $area)
                                                <option value="{{ $area->idArea }}" 
                                                    {{ old('Area_id', $boss->Area_id) == $area->idArea ? 'selected' : '' }}>
                                                    {{ $area->Name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('Area_id')
                                            <small class="text-danger">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>
                                </form>
                            </x-modal-base>
                        @endcan
                    @endforeach

                </x-data-table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dniInputs = document.querySelectorAll('input[name="Document"]');
            dniInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length > 8) {
                        this.value = this.value.slice(0, 8);
                    }
                });
            });

            const phoneInputs = document.querySelectorAll('input[name="Phone"]');
            phoneInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9+-\s()]/g, '');
                });
            });

            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const dniInput = this.querySelector('input[name="Document"]');
                    const nameInput = this.querySelector('input[name="Name"]');
                    const cargoInput = this.querySelector('input[name="Cargo"]');
                    const areaSelect = this.querySelector('select[name="Area_id"]');
                    
                    if (dniInput && dniInput.value.length !== 8) {
                        e.preventDefault();
                        alert('El DNI debe tener exactamente 8 dígitos');
                        dniInput.focus();
                        return false;
                    }
                    
                    if (nameInput && nameInput.value.trim() === '') {
                        e.preventDefault();
                        alert('El campo nombre es obligatorio');
                        nameInput.focus();
                        return false;
                    }
                    
                    if (cargoInput && cargoInput.value.trim() === '') {
                        e.preventDefault();
                        alert('El campo cargo es obligatorio');
                        cargoInput.focus();
                        return false;
                    }
                    
                    if (areaSelect && areaSelect.value === '') {
                        e.preventDefault();
                        alert('Debe seleccionar un área');
                        areaSelect.focus();
                        return false;
                    }
                });
            });

            console.log('Página de jefes cargada correctamente');
        });
    </script>
@endpush