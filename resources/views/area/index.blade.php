@extends('template')
@section('title', 'Area')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')

    <div class="container-fluid">
        <div class="row pt-2">
            <x-card-header title="AREAS" icon="fa-solid fa-sitemap">
                <form action="{{ route('area.store') }}" method="POST" class="row">
                    @csrf

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Nombre del Area:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Name" class="form-control" placeholder="Ingresar nombre area"
                            value="{{ old('Name') }}" required>
                        @error('Name')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Sede:<span class="text-danger">*</span>
                        </label>
                        <select name="Headquarters_id" class="form-control selectpicker show-tick" data-size="5" data-live-search="true" required>
                            <option value="" disabled {{ old('Headquarters_id') ? '' : 'selected' }}>Seleccionar Sede
                            </option>
                            @foreach ($headquarters as $hq)
                                <option value="{{ $hq->idHeadquarters }}"
                                    {{ old('Headquarters_id') == $hq->idHeadquarters ? 'selected' : '' }}>
                                    {{ $hq->Name }}
                                </option>
                            @endforeach
                        </select>
                        @error('Headquarters_id')
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
                    ['label' => 'NOMBRE DE AREA'],
                    ['label' => 'SEDE'],
                    ['label' => 'ESTADO', 'class' => 'text-center'],
                    ['label' => 'ACCIONES', 'class' => 'text-center'],
                ]" table-id="example">

                    @foreach ($areas as $area)
                        <tr>
                            <td>
                                <div class="info-label">{{ $area->Name }}</div>
                            </td>
                            <td>
                                <div class="info-label">{{ $area->headquarters->Name }}</div>
                            </td>
                            <td class="text-center">
                                @if ($area->Status == 1)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalEditar{{ $area->idArea }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn {{ $area->Status == 1 ? 'btn-danger' : 'btn-success' }} btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#modalEstado{{ $area->idArea }}">
                                    <i
                                        class="fa-solid {{ $area->Status == 1 ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                </button>
                            </td>
                        </tr>

                        <x-modal-status id="modalEstado{{ $area->idArea }}"
                            message="¿Seguro que deseas {{ $area->Status == 1 ? 'desactivar' : 'activar' }} el área '{{ $area->Name }}'?"
                            action="{{ route('area.destroy', $area->idArea) }}"
                            confirmText="{{ $area->Status == 1 ? 'Desactivar' : 'Activar' }}"
                            confirmClass="{{ $area->Status == 1 ? 'btn-danger' : 'btn-success' }}" />

                        <x-modal-base id="modalEditar{{ $area->idArea }}" title="Editar Area" size="modal-md">
                            <form action="{{ route('area.update', $area->idArea) }}" method="POST" class="row">
                                @csrf
                                @method('PUT')

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        Nombre del Area:<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="Name" class="form-control" value="{{ $area->Name }}" placeholder="Ingresar nombre area"
                                        required>
                                </div>

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        Sede:<span class="text-danger">*</span>
                                    </label>
                                    <select name="Headquarters_id" class="form-control selectpicker show-tick" data-size="5" data-live-search="true"  required>
                                        @foreach ($headquarters as $hq)
                                            <option value="{{ $hq->idHeadquarters }}"
                                                {{ $area->Headquarters_id == $hq->idHeadquarters ? 'selected' : '' }}>
                                                {{ $hq->Name }}
                                            </option>
                                        @endforeach
                                    </select>
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
