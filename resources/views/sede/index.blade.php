@extends('template')
@section('title', 'Sedes')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')

    <div class="container-fluid">
        <div class="row pt-2">
            <x-card-header title="SEDES" icon="fa-solid fa-building">
                @can('Crear-Sedes')
                <form action="{{ route('sede.store') }}" method="POST" class="row">
                    @csrf

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Nombre de sede:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Name" class="form-control @error('Name') is-invalid @enderror" 
                            placeholder="Ingresar nombre" value="{{ old('Name') }}" required>
                        @error('Name')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Dirección:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Address" class="form-control @error('Address') is-invalid @enderror" 
                            placeholder="Ingresar dirección" value="{{ old('Address') }}" required>
                        @error('Address')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Teléfono:<span class="text-danger">*</span></label>
                        <input type="text" name="Phone" class="form-control @error('Phone') is-invalid @enderror" 
                            placeholder="Ingresar teléfono" value="{{ old('Phone') }}">
                        @error('Phone')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <input type="hidden" name="Entity_id" value="1">

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                        </button>
                    </div>
                </form>
                @else
                    <div class="alert alert-info text-center py-3">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        No tienes permisos para crear sedes
                    </div>
                @endcan
            </x-card-header>
        </div>

        <div class="row pt-3">
            <div class="col-lg-12">
                <x-data-table :columns="[
                    ['label' => 'NOMBRE DE SEDE'],
                    ['label' => 'DIRECCIÓN'],
                    ['label' => 'TELÉFONO', 'class' => 'text-center'],
                    ['label' => 'ESTADO', 'class' => 'text-center'],
                    ['label' => 'ACCIÓN', 'class' => 'text-center'],
                ]" table-id="example">

                    @foreach ($headquarters as $hq)
                        <tr>
                            <td>{{ $hq->Name }}</td>
                            <td>{{ $hq->Address }}</td>
                            <td class="text-center">{{ $hq->Phone }}</td>
                            <td class="text-center">
                                @if ($hq->Status == 1)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @can('Editar-Sedes')
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEditar{{ $hq->idHeadquarters }}" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                @endcan
                                
                                @can('Estado-Sedes')
                                    <button class="btn {{ $hq->Status == 1 ? 'btn-danger' : 'btn-success' }} btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#modalEstado{{ $hq->idHeadquarters }}"
                                        title="{{ $hq->Status == 1 ? 'Desactivar' : 'Activar' }}">
                                        <i class="fa-solid {{ $hq->Status == 1 ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>

                        {{-- Modal Estado --}}
                        @can('Estado-Sedes')
                            <x-modal-status id="modalEstado{{ $hq->idHeadquarters }}"
                                message="¿Seguro que deseas {{ $hq->Status == 1 ? 'desactivar' : 'activar' }} la sede '{{ $hq->Name }}'?"
                                action="{{ route('sede.destroy', $hq->idHeadquarters) }}"
                                confirmText="{{ $hq->Status == 1 ? 'Desactivar' : 'Activar' }}"
                                confirmClass="{{ $hq->Status == 1 ? 'btn-danger' : 'btn-success' }}" 
                                method="DELETE" />
                        @endcan

                        {{-- Modal Editar --}}
                        @can('Editar-Sedes')
                            <x-modal-base id="modalEditar{{ $hq->idHeadquarters }}" title="Editar Sede: {{ $hq->Name }}" 
                                size="modal-lg" formId="formEditar{{ $hq->idHeadquarters }}">
                                <form action="{{ route('sede.update', $hq->idHeadquarters) }}" method="POST" 
                                    class="row" id="formEditar{{ $hq->idHeadquarters }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            Nombre de sede:<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="Name" class="form-control @error('Name') is-invalid @enderror" 
                                            value="{{ old('Name', $hq->Name) }}" required>
                                        @error('Name')
                                            <small class="text-danger">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            Dirección:<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="Address" class="form-control @error('Address') is-invalid @enderror" 
                                            value="{{ old('Address', $hq->Address) }}" required>
                                        @error('Address')
                                            <small class="text-danger">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 pt-2">
                                        <label class="form-label fw-semibold">
                                            Teléfono:<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="Phone" class="form-control @error('Phone') is-invalid @enderror" 
                                            value="{{ old('Phone', $hq->Phone) }}">
                                        @error('Phone')
                                            <small class="text-danger">{{ '*' . $message }}</small>
                                        @enderror
                                    </div>

                                    <input type="hidden" name="Entity_id" value="{{ $hq->Entity_id }}">
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
            const phoneInputs = document.querySelectorAll('input[name="Phone"]');
            phoneInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9+-\s()]/g, '');
                });
            });

            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const nameInput = this.querySelector('input[name="Name"]');
                    const addressInput = this.querySelector('input[name="Address"]');
                    
                    if (nameInput && nameInput.value.trim() === '') {
                        e.preventDefault();
                        alert('El campo nombre de sede es obligatorio');
                        nameInput.focus();
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

            console.log('Página de sedes cargada correctamente');
        });
    </script>
@endpush