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
                @can('Crear-Proveedor')
                <form action="{{ route('proveedor.store') }}" method="POST" class="row">
                    @csrf
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Empresa:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Company_name" class="form-control @error('Company_name') is-invalid @enderror" 
                               placeholder="Ingrese nombre empresa" value="{{ old('Company_name') }}" required>
                        @error('Company_name')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            RUC:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Ruc" class="form-control @error('Ruc') is-invalid @enderror" 
                               placeholder="Ingrese ruc" value="{{ old('Ruc') }}" required maxlength="11">
                        @error('Ruc')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Teléfono:
                        </label>
                        <input type="text" name="Phone" class="form-control @error('Phone') is-invalid @enderror" 
                               placeholder="Ingrese teléfono" value="{{ old('Phone') }}">
                        @error('Phone')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Dirección:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Address" class="form-control @error('Address') is-invalid @enderror" 
                               placeholder="Ingrese dirección" value="{{ old('Address') }}" required>
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
                @else
                    <div class="alert alert-info text-center py-3">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        No tienes permisos para crear proveedores
                    </div>
                @endcan
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
                ]" table-id="example">

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
                                @can('Editar-Proveedor')
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                                        data-bs-target="#modalEditar{{ $supplier->idSupplier }}" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                @endcan
                                
                                @can('Estado-Proveedor')
                                    <button class="btn {{ $supplier->Status == 1 ? 'btn-danger' : 'btn-success' }} btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEstado{{ $supplier->idSupplier }}"
                                        title="{{ $supplier->Status == 1 ? 'Desactivar' : 'Activar' }}">
                                        <i class="fa-solid {{ $supplier->Status == 1 ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>

                        @can('Estado-Proveedor')
                            <x-modal-status 
                                id="modalEstado{{ $supplier->idSupplier }}"
                                message="¿Seguro que deseas {{ $supplier->Status == 1 ? 'desactivar' : 'activar' }} al proveedor '{{ $supplier->Company_name }}'?"
                                action="{{ route('proveedor.destroy', $supplier->idSupplier) }}"
                                confirmText="{{ $supplier->Status == 1 ? 'Desactivar' : 'Activar' }}"
                                confirmClass="{{ $supplier->Status == 1 ? 'btn-danger' : 'btn-success' }}"
                                method="DELETE" />
                        @endcan

                        @can('Editar-Proveedor')
                            <x-modal-base id="modalEditar{{ $supplier->idSupplier }}" title="Editar Proveedor: {{ $supplier->Company_name }}" 
                                size="modal-sm" formId="formEditar{{ $supplier->idSupplier }}">
                                <form action="{{ route('proveedor.update', $supplier->idSupplier) }}" method="POST" 
                                    class="row" id="formEditar{{ $supplier->idSupplier }}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            Empresa:<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="Company_name" class="form-control @error('Company_name') is-invalid @enderror" 
                                               value="{{ old('Company_name', $supplier->Company_name) }}" required>
                                        @error('Company_name')
                                            <small class="text-danger">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            RUC:<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="Ruc" class="form-control @error('Ruc') is-invalid @enderror" 
                                               value="{{ old('Ruc', $supplier->Ruc) }}" required maxlength="11">
                                        @error('Ruc')
                                            <small class="text-danger">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            Teléfono:
                                        </label>
                                        <input type="text" name="Phone" class="form-control @error('Phone') is-invalid @enderror" 
                                               value="{{ old('Phone', $supplier->Phone) }}">
                                        @error('Phone')
                                            <small class="text-danger">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            Dirección:<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="Address" class="form-control @error('Address') is-invalid @enderror" 
                                               value="{{ old('Address', $supplier->Address) }}" required>
                                        @error('Address')
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
            // Validación de RUC (solo números, 11 dígitos)
            const rucInputs = document.querySelectorAll('input[name="Ruc"]');
            rucInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length > 11) {
                        this.value = this.value.slice(0, 11);
                    }
                });
            });

            // Validación de teléfono
            const phoneInputs = document.querySelectorAll('input[name="Phone"]');
            phoneInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9+-\s()]/g, '');
                });
            });

            // Validación de formularios
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const companyInput = this.querySelector('input[name="Company_name"]');
                    const rucInput = this.querySelector('input[name="Ruc"]');
                    const addressInput = this.querySelector('input[name="Address"]');
                    
                    if (companyInput && companyInput.value.trim() === '') {
                        e.preventDefault();
                        alert('El campo empresa es obligatorio');
                        companyInput.focus();
                        return false;
                    }
                    
                    if (rucInput && rucInput.value.length !== 11) {
                        e.preventDefault();
                        alert('El RUC debe tener exactamente 11 dígitos');
                        rucInput.focus();
                        return false;
                    }
                    
                    if (addressInput && addressInput.value.trim() === '') {
                        e.preventDefault();
                        alert('El campo dirección es obligatorio');
                        addressInput.focus();
                        return false;
                    }
                });
            });

            console.log('Página de proveedores cargada correctamente');
        });
    </script>
@endpush