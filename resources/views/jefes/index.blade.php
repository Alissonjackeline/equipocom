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
                <form action="{{ route('jefes.store') }}" method="POST" class="row g-3">
                    @csrf
                    
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            DNI:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Document" class="form-control" placeholder="Ingrese DNI" 
                               value="{{ old('Document') }}" required maxlength="8">
                        @error('Document')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Nombre:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Name" class="form-control" placeholder="Ingrese nombre" 
                               value="{{ old('Name') }}" required>
                        @error('Name')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Cargo:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Cargo" class="form-control" placeholder="Ingrese cargo" 
                               value="{{ old('Cargo') }}" required>
                        @error('Cargo')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Teléfono:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Phone" class="form-control" placeholder="Ingrese teléfono" required
                               value="{{ old('Phone') }}">
                        @error('Phone')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Área:<span class="text-danger">*</span>
                        </label>
                        <select class="form-select" name="Area_id" required>
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
                                <div class="info-label">{{ $boss->area->Name }}</div>
                            </td>
                            <td class="text-center">
                                @if ($boss->Status == 1)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                    data-bs-target="#modalEditar{{ $boss->idBoss }}" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn {{ $boss->Status == 1 ? 'btn-danger' : 'btn-success' }} btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEstado{{ $boss->idBoss }}"
                                    title="{{ $boss->Status == 1 ? 'Desactivar' : 'Activar' }}">
                                    <i class="fa-solid {{ $boss->Status == 1 ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal para cambiar estado -->
                        <x-modal-status 
                            id="modalEstado{{ $boss->idBoss }}"
                            message="¿Seguro que deseas {{ $boss->Status == 1 ? 'desactivar' : 'activar' }} al jefe '{{ $boss->Name }}'?"
                            action="{{ route('jefes.destroy', $boss->idBoss) }}"
                            confirmText="{{ $boss->Status == 1 ? 'Desactivar' : 'Activar' }}"
                            confirmClass="{{ $boss->Status == 1 ? 'btn-danger' : 'btn-success' }}" />

                        <!-- Modal para editar -->
                        <x-modal-base id="modalEditar{{ $boss->idBoss }}" title="Editar Jefe" size="modal-sm">
                            <form action="{{ route('jefes.update', $boss->idBoss) }}" method="POST" class="row g-3">
                                @csrf
                                @method('PUT')
                                
                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        DNI:<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="Document" class="form-control" 
                                           value="{{ old('Document', $boss->Document) }}" required maxlength="8">
                                    @error('Document')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        Nombre:<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="Name" class="form-control" 
                                           value="{{ old('Name', $boss->Name) }}" required>
                                    @error('Name')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        Cargo:<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="Cargo" class="form-control" 
                                           value="{{ old('Cargo', $boss->Cargo) }}" required>
                                    @error('Cargo')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        Teléfono:<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="Phone" class="form-control" 
                                           value="{{ old('Phone', $boss->Phone) }}">
                                    @error('Phone')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        Área:<span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="Area_id" required>
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
                        </x-modal-base>
                        </form>
                    @endforeach

                </x-data-table>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush