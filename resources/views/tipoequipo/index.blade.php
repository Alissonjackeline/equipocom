@extends('template')
@section('title', 'Tipos de Equipo')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')

    <div class="container-fluid">
        <div class="row pt-2">
            <x-card-header title="TIPOS DE EQUIPO" icon="fa-solid fa-computer">
                <form action="{{ route('tipoequipo.store') }}" method="POST" class="row">
                    @csrf

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Nombre:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Name" class="form-control" placeholder="Ingresar nombre"
                            value="{{ old('Name') }}" required>
                        @error('Name')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Descripción:</label>
                        <input type="text" name="Description" class="form-control" placeholder="Ingresar descripción"
                            value="{{ old('Description') }}">
                        @error('Description')
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
                    ['label' => 'NOMBRE'],
                    ['label' => 'DESCRIPCIÓN'],
                    ['label' => 'ESTADO', 'class' => 'text-center'],
                    ['label' => 'ACCIONES', 'class' => 'text-center'],
                ]" table-id="example">

                    @foreach ($equipmentTypes as $type)
                        <tr>
                            <td>
                                <div class="info-label">{{ $type->Name }}</div>
                            </td>
                            <td>
                                <div class="info-label">{{ $type->Description ?? 'N/A' }}</div>
                            </td>
                            <td class="text-center">
                                @if ($type->Status == 1)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalEditar{{ $type->idEquipmentType }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn {{ $type->Status == 1 ? 'btn-danger' : 'btn-success' }} btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#modalEstado{{ $type->idEquipmentType }}">
                                    <i
                                        class="fa-solid {{ $type->Status == 1 ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                </button>
                            </td>
                        </tr>

                        <x-modal-status id="modalEstado{{ $type->idEquipmentType }}"
                            message="¿Seguro que deseas {{ $type->Status == 1 ? 'desactivar' : 'activar' }} el tipo de equipo '{{ $type->Name }}'?"
                            action="{{ route('tipoequipo.destroy', $type->idEquipmentType) }}"
                            confirmText="{{ $type->Status == 1 ? 'Desactivar' : 'Activar' }}"
                            confirmClass="{{ $type->Status == 1 ? 'btn-danger' : 'btn-success' }}" />

                        <x-modal-base id="modalEditar{{ $type->idEquipmentType }}" title="Editar Tipo de Equipo"
                            size="modal-sm">
                            <form action="{{ route('tipoequipo.update', $type->idEquipmentType) }}" method="POST"
                                class="row">
                                @csrf
                                @method('PUT')

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        Nombre:<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="Name" class="form-control"
                                        value="{{ old('Name', $type->Name) }}" required>
                                    @error('Name')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">Descripción:</label>
                                    <input type="text" name="Description" class="form-control"
                                        value="{{ old('Description', $type->Description) }}">
                                    @error('Description')
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
