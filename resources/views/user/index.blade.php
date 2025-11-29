@extends('template')
@section('title', 'Usuarios')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')

    <div class="container-fluid">
        <div class="row pt-3">
            <div class="col-lg-12">
                <x-card-header title="LISTA DE USUARIOS" icon="fa-solid fa-users" :buttons="[
                    [
                        'text' => 'Agregar',
                        'icon' => 'fa-solid fa-circle-plus me-1',
                        'route' => route('user.create'),
                        'variant' => 'persona',
                        'permission' => 'Crear-Usuario', 
                    ],
                ]">

                    <x-data-table :columns="[
                        ['label' => 'NOMBRES COMPLETOS'],
                        ['label' => 'ROL'],
                        ['label' => 'TELEFONO', 'class' => 'text-center'],
                        ['label' => 'EMAIL', 'class' => 'text-center'],
                        ['label' => 'ESTADO', 'class' => 'text-center'],
                        ['label' => 'ACCIONES', 'class' => 'text-center'],
                    ]" table-id="example">

                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="mb-1">
                                        <span class="info-label">{{ $user->Name }}</span>
                                        <span class="info-value">{{ $user->Document }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($user->getRoleNames()->count() > 0)
                                        @if ($user->getRoleNames()->first() === 'administrador')
                                            <span class="badge text-bg-warning">
                                                <i class="fa-solid fa-crown me-1"></i>{{ $user->getRoleNames()->first() }}
                                            </span>
                                        @else
                                            <span class="badge text-bg-info">
                                                <i class="fa-solid fa-user me-1"></i>{{ $user->getRoleNames()->first() }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge bg-purple text-white">
                                            <i class="fa-solid fa-user me-1"></i>Sin rol
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="info-label">{{ $user->Phone }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="info-label">{{ $user->Email }}</div>
                                </td>
                                <td class="text-center">
                                    @if ($user->Status == 1)
                                        <span class="badge text-bg-success">Activo</span>
                                    @else
                                        <span class="badge text-bg-danger">Inactivo</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @can('Editar-Usuario')
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEditar{{ $user->idUser }}" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    @endcan
                                    
                                    @can('Estado-Usuario')
                                        <button class="btn {{ $user->Status == 1 ? 'btn-danger' : 'btn-success' }} btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#modalEstado{{ $user->idUser }}"
                                            title="{{ $user->Status == 1 ? 'Desactivar' : 'Activar' }}">
                                            <i class="fa-solid {{ $user->Status == 1 ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                        </button>
                                    @endcan

                                </td>
                            </tr>
                        @endforeach

                    </x-data-table>
                </x-card-header>
            </div>
        </div>
    </div>

    {{-- Modales --}}
    @foreach ($users as $user)
        {{-- Modal Estado --}}
        @can('Estado-Usuario')
            <x-modal-status id="modalEstado{{ $user->idUser }}"
                message="¿Seguro que deseas {{ $user->Status == 1 ? 'desactivar' : 'activar' }} al usuario '{{ $user->Name }}'?"
                action="{{ route('user.destroy', $user->idUser) }}"
                confirmText="{{ $user->Status == 1 ? 'Desactivar' : 'Activar' }}"
                confirmClass="{{ $user->Status == 1 ? 'btn-danger' : 'btn-success' }}" method="DELETE" />
        @endcan

        {{-- Modal Editar --}}
        @can('Editar-Usuario')
            <x-modal-base id="modalEditar{{ $user->idUser }}" title="Editar Usuario" size="modal-lg"
                formId="formEditar{{ $user->idUser }}">
                <form action="{{ route('user.update', $user->idUser) }}" method="POST" class="row"
                    id="formEditar{{ $user->idUser }}">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6 pt-2">
                        <label class="form-label fw-semibold">
                            DNI:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="document" class="form-control @error('document') is-invalid @enderror"
                            value="{{ old('document', $user->Document) }}" required maxlength="8">
                        @error('document')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 pt-2">
                        <label class="form-label fw-semibold">
                            Nombres completos:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->Name) }}" required maxlength="70">
                        @error('name')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 pt-2">
                        <label class="form-label fw-semibold">
                            Teléfono:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $user->Phone) }}" required maxlength="20">
                        @error('phone')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 pt-2">
                        <label class="form-label fw-semibold">
                            Correo:<span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->Email) }}" required maxlength="50">
                        @error('email')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 pt-2">
                        <label class="form-label fw-semibold">
                            Rol:<span class="text-danger">*</span>
                        </label>
                        <select name="role" class="form-control selectpicker show-tick @error('role') is-invalid @enderror" required>
                            <option value="" disabled>Seleccionar Rol</option>
                            @foreach ($roles as $roleItem)
                                <option value="{{ $roleItem->name }}"
                                    {{ $user->getRoleNames()->first() == $roleItem->name ? 'selected' : '' }}>
                                    {{ $roleItem->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 pt-2">
                        <label class="form-label fw-semibold">
                            Contraseña: <small class="text-muted">(Dejar vacío para no cambiar)</small>
                        </label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Nueva contraseña" minlength="8">
                        @error('password')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 pt-2">
                        <label class="form-label fw-semibold">
                            Confirmar Contraseña:
                        </label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirmar nueva contraseña" minlength="8">
                    </div>
                </form>
            </x-modal-base>
        @endcan
    @endforeach

@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dniInputs = document.querySelectorAll('input[name="document"]');
            dniInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });

            const phoneInputs = document.querySelectorAll('input[name="phone"]');
            phoneInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9+-\s]/g, '');
                });
            });

            console.log('Página de usuarios cargada correctamente');
        });
    </script>
@endpush