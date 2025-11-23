@extends('template')
@section('title', 'Crear inventario')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
@include('layouts.partials.alert')

    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header title="AGREGAR EQUIPO" icon="fa-solid fa-computer" :buttons="[
                [
                    'text' => 'Inventario',
                    'icon' => 'fa-solid fa-computer',
                    'route' => route('inventario.index'),
                    'variant' => 'persona',
                ],
                [
                    'text' => 'Historial',
                    'icon' => 'fa-solid fa-magnifying-glass me-1',
                    'route' => route('inventario.historial'),
                    'variant' => 'secondary',
                ],
            ]">

                <form action="{{ route('inventario.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="EquipmentType_id">
                                Tipo de equipo:
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control selectpicker show-tick" data-size="5" data-live-search="true" id="EquipmentType_id" name="EquipmentType_id" required>
                                <option value="" selected disabled>Seleccionar tipo de equipo</option>
                                @foreach ($equipmentTypes as $type)
                                    <option value="{{ $type->idEquipmentType }}"
                                        {{ old('EquipmentType_id') == $type->idEquipmentType ? 'selected' : '' }}>
                                        {{ $type->Name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('EquipmentType_id')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="CodigoPatri">
                                Código patrimonial:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="CodigoPatri" name="CodigoPatri"
                                placeholder="7278992025" value="{{ old('CodigoPatri') }}" required>
                            @error('CodigoPatri')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="Series">
                                Serie:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="Series" name="Series"
                                placeholder="SNFH57392K" value="{{ old('Series') }}" required>
                            @error('Series')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="Model">
                                Modelo:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="Model" name="Model" placeholder="SNF-555"
                                value="{{ old('Model') }}" required>
                            @error('Model')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="Brand">
                                Marca:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="Brand" name="Brand"
                                placeholder="Ej: HP, Dell, Lenovo" value="{{ old('Brand') }}" required>
                            @error('Brand')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="Supplier_id">
                                Proveedor:
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control selectpicker show-tick" data-size="5" data-live-search="true"  id="Supplier_id" name="Supplier_id" required>
                                <option value="" selected disabled>Seleccionar proveedor</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->idSupplier }}"
                                        {{ old('Supplier_id') == $supplier->idSupplier ? 'selected' : '' }}>
                                        {{ $supplier->Company_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('Supplier_id')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="Price">
                                Precio (S/):
                            </label>
                            <input type="number" step="0.01" class="form-control" id="Price" name="Price"
                                placeholder="0.00" value="{{ old('Price') }}">
                            @error('Price')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="status">
                                Estado:
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control selectpicker show-tick" data-size="5" data-live-search="true" id="status" name="status" required>
                                <option value="" selected disabled>Seleccionar estado</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Disponible</option>
                                <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Por preparar</option>
                                <option value="3" {{ old('status') == '3' ? 'selected' : '' }}>En uso</option>
                                <option value="4" {{ old('status') == '4' ? 'selected' : '' }}>Observación</option>
                                <option value="5" {{ old('status') == '5' ? 'selected' : '' }}>R Pendiente</option>
                                <option value="6" {{ old('status') == '6' ? 'selected' : '' }}>No devuelto</option>
                                <option value="7" {{ old('status') == '7' ? 'selected' : '' }}>Perdida-Robo</option>
                                <option value="8" {{ old('status') == '8' ? 'selected' : '' }}>De baja</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="Description">
                                Descripción:
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="Description" name="Description" rows="3" required>{{ old('Description') }}</textarea>
                            @error('Description')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="Imagen">
                                Imagen:
                            </label>
                            <input class="form-control" type="file" id="Imagen" name="Imagen" accept="image/*">
                            @error('Imagen')
                                <small class="text-danger">{{ '*' . $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end pt-4">
                        <a href="{{ route('inventario.index') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-times"></i>&nbsp;Cancelar
                        </a>
                        <button class="btn btn-primary mx-2" type="submit">
                            <i class="fa-solid fa-floppy-disk"></i> GUARDAR
                        </button>
                    </div>
                </form>

            </x-card-header>
        </div>
    </div>
@endsection

@push('js')
@endpush
