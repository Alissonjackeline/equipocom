@extends('template')
@section('title', 'Proveedor')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')

    <div class="container-fluid">
        <div class="row pt-2">
            <x-card-header title="PROVEEDORES" icon="fa-solid fa-boxes-packing">
                <form action="{{ route('proveedor.store') }}" method="POST" class="row">
                    @csrf
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Empresa:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Company_name" class="form-control" 
                               placeholder="Ingrese nombre empresa" value="{{ old('Company_name') }}" required>
                        @error('Company_name')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            RUC:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Ruc" class="form-control" placeholder="Ingrese ruc" 
                               value="{{ old('Ruc') }}" required maxlength="11">
                        @error('Ruc')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Teléfono:
                        </label>
                        <input type="text" name="Phone" class="form-control" placeholder="Ingrese teléfono" 
                               value="{{ old('Phone') }}">
                        @error('Phone')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Dirección:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Address" class="form-control" placeholder="Ingrese dirección" 
                               value="{{ old('Address') }}" required>
                        @error('Address')
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
                    ['label' => 'NOMBRE DE EMPRESA'],
                    ['label' => 'RUC'],
                    ['label' => 'TELÉFONO', 'class' => 'text-center'],
                    ['label' => 'DIRECCIÓN'],
                    ['label' => 'ESTADO', 'class' => 'text-center'],
                    ['label' => 'ACCIONES', 'class' => 'text-center'],
                ]"  table-id="example">

                    @foreach ($suppliers as $supplier)
                        <tr>
                            <td>
                                <div class="info-label">{{ $supplier->Company_name }}</div>
                            </td>
                            <td>
                                <div class="info-label">{{ $supplier->Ruc }}</div>
                            </td>
                            <td class="text-center">
                                <div class="info-label">{{ $supplier->Phone ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div class="info-label">{{ $supplier->Address }}</div>
                            </td>
                            <td class="text-center">
                                @if ($supplier->Status == 1)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                    data-bs-target="#modalEditar{{ $supplier->idSupplier }}" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn {{ $supplier->Status == 1 ? 'btn-danger' : 'btn-success' }} btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEstado{{ $supplier->idSupplier }}"
                                    title="{{ $supplier->Status == 1 ? 'Desactivar' : 'Activar' }}">
                                    <i class="fa-solid {{ $supplier->Status == 1 ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal para cambiar estado -->
                        <x-modal-status 
                            id="modalEstado{{ $supplier->idSupplier }}"
                            message="¿Seguro que deseas {{ $supplier->Status == 1 ? 'desactivar' : 'activar' }} al proveedor '{{ $supplier->Company_name }}'?"
                            action="{{ route('proveedor.destroy', $supplier->idSupplier) }}"
                            confirmText="{{ $supplier->Status == 1 ? 'Desactivar' : 'Activar' }}"
                            confirmClass="{{ $supplier->Status == 1 ? 'btn-danger' : 'btn-success' }}" />

                        <!-- Modal para editar -->
                        <x-modal-base id="modalEditar{{ $supplier->idSupplier }}" title="Editar Proveedor" size="modal-sm">
                            <form action="{{ route('proveedor.update', $supplier->idSupplier) }}" method="POST" class="row">
                                @csrf
                                @method('PUT')
                                
                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        Empresa:<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="Company_name" class="form-control" 
                                           value="{{ old('Company_name', $supplier->Company_name) }}" required>
                                    @error('Company_name')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        RUC:<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="Ruc" class="form-control" 
                                           value="{{ old('Ruc', $supplier->Ruc) }}" required maxlength="11">
                                    @error('Ruc')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        Teléfono:
                                    </label>
                                    <input type="text" name="Phone" class="form-control" 
                                           value="{{ old('Phone', $supplier->Phone) }}" required>
                                    @error('Phone')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">
                                        Dirección:<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="Address" class="form-control" 
                                           value="{{ old('Address', $supplier->Address) }}" required>
                                    @error('Address')
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