@extends('template')
@section('title', 'Roles')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header title="LISTA DE ROLES" icon="fa-solid fa-address-card" :buttons="[
                [
                    'text' => 'Agregar',
                    'icon' => 'fa-solid fa-circle-plus me-1',
                    'route' => route('roles.create'),
                    'variant' => 'persona',
                    'permission' => 'Crear-Rol',
                ],
            ]">

                <x-data-table :columns="[
                    ['label' => 'ROL'],
                    ['label' => 'PERMISOS'],
                    ['label' => 'ACCIONES', 'class' => 'text-center'],
                ]" table-id="example">

                    @foreach ($roles as $role)
                        <tr>
                            <td>
                                <div class="mb-1">
                                    <span class="info-value">{{ $role->name }}</span>
                                    <small class="text-muted d-block">Creado:
                                        {{ $role->created_at->format('d/m/Y') }}</small>
                                </div>
                            </td>
                            <td>
                                @if ($role->permissions->count() > 0)
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($role->permissions as $permission)
                                            <span class="badge text-bg-primary">{{ $permission->name }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="badge text-bg-warning">Sin permisos asignados</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @can('Editar-Rol')
                                    <button class="btn btn-warning btn-sm action-btn" title="Editar" data-bs-toggle="modal"
                                        data-bs-target="#modalEditar{{ $role->id }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                @endcan

                                @can('Eliminar-Rol')
                                    <button class="btn btn-danger btn-sm action-btn" title="Eliminar" data-bs-toggle="modal"
                                        data-bs-target="#modalEliminar{{ $role->id }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>

                        {{-- Modal Editar --}}
                        @can('Editar-Rol')
                            <x-modal-base id="modalEditar{{ $role->id }}" title="Editar Rol: {{ $role->name }}"
                                size="modal-lg" formId="formEditar{{ $role->id }}">
                                <form action="{{ route('roles.update', $role->id) }}" method="POST"
                                    id="formEditar{{ $role->id }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label fw-semibold">
                                                Nombre del Rol:<span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $role->name) }}" required>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">
                                                Permisos:<span class="text-danger">*</span>
                                            </label>
                                            <div class="row">
                                                @foreach ($permissions as $permission)
                                                    <div class="col-md-4 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="permission[]"
                                                                value="{{ $permission->id }}"
                                                                id="perm_{{ $role->id }}_{{ $permission->id }}"
                                                                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="perm_{{ $role->id }}_{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </x-modal-base>
                        @endcan

                        {{-- Modal Eliminar --}}
                        @can('Eliminar-Rol')
                            <x-modal-status id="modalEliminar{{ $role->id }}"
                                message="¿Seguro que deseas eliminar el rol '{{ $role->name }}'? Esta acción no se puede deshacer."
                                action="{{ route('roles.destroy', $role->id) }}" confirmText="Eliminar"
                                confirmClass="btn-danger" method="DELETE" />
                        @endcan
                    @endforeach

                </x-data-table>
            </x-card-header>
        </div>
    </div>
@endsection

@push('js')
@endpush
