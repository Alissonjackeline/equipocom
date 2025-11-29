@extends('template')
@section('title', 'Crear Rol')

@push('css')
    <!-- Datatables -->
    <link href="{{ asset('Css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('Css/buttons.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')
    <div class="container-fluid">
        @can('Crear-Rol')
            <div class="col-12 pt-4">
                <div class="card shadow-sm border-0">
                    <h5 class="card-header text-white" id="encabezado">
                        <i class="fa-solid fa-circle-plus"></i> Crear Rol
                    </h5>
                    <div class="card-body">
                        <form action="{{ route('roles.store') }}" method="post">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="name" class="fw-bold">Rol: <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Ingrese Rol" value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ '*' . $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="button" class="btn btn-success btn-sm me-2" id="selectAllGlobal">
                                    <i class="fa-solid fa-check-double"></i> Seleccionar todos
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" id="deselectAllGlobal">
                                    <i class="fa-solid fa-ban"></i> Deseleccionar todos
                                </button>
                            </div>

                            <h6 class="fw-bold mb-3">Permisos: <span class="text-danger">*</span></h6>

                            <div class="row g-3">
                                @php
                                    $groups = [
                                        'Catalogo' => ['Ver-Catalogo'],
                                        'Empresa' => ['Editar-Empresa'],
                                        'Sedes' => ['Ver-Sedes', 'Crear-Sedes', 'Editar-Sedes', 'Estado-Sedes'],
                                        'Areas' => ['Ver-Areas', 'Crear-Areas', 'Editar-Areas', 'Estado-Areas'],
                                        'Usuario' => ['Ver-Usuario', 'Crear-Usuario', 'Editar-Usuario', 'Estado-Usuario'],
                                        'Rol' => ['Ver-Rol', 'Crear-Rol', 'Editar-Rol', 'Eliminar-Rol'],
                                        'Perfil' => ['Perfil'],
                                        'Tipo-Equipo' => ['Ver-Tipo-Equipo', 'Crear-Tipo-Equipo', 'Editar-Tipo-Equipo', 'Estado-Tipo-Equipo'],
                                        'Jefe' => ['Ver-Jefe', 'Crear-Jefe', 'Editar-Jefe', 'Estado-Jefe'],
                                        'Proveedor' => ['Ver-Proveedor', 'Crear-Proveedor', 'Editar-Proveedor', 'Estado-Proveedor'],
                                        'Inventario' => ['Ver-Inventario', 'Crear-Inventario', 'Editar-Inventario', 'Eliminar-Inventario', 'Historial-Inventario'],
                                        'Asignacion' => ['Ver-Asignacion', 'Crear-Asignacion', 'Editar-Asignacion', 'Eliminar-Asignacion'],
                                        'Devolucion' => ['Ver-Devolucion', 'Crear-Devolucion', 'Editar-Devolucion', 'Eliminar-Devolucion'],
                                    ];
                                @endphp

                                @foreach ($groups as $groupName => $groupPermissions)
                                    <div class="col-12 col-md-4">
                                        <div class="border rounded shadow-sm h-100">
                                            <div class="d-flex justify-content-between align-items-center text-white px-3 py-2"
                                                id="encabezado">
                                                <strong>{{ $groupName }}</strong>
                                                <button type="button" class="btn btn-success btn-sm select-all"
                                                    data-group="{{ $groupName }}">
                                                    <i class="fa-solid fa-check"></i> Todos
                                                </button>
                                            </div>

                                            <div class="p-3">
                                                <div class="row">
                                                    @foreach ($permissions as $permission)
                                                        @if (in_array($permission->name, $groupPermissions))
                                                            <div class="col-12">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input permission-checkbox"
                                                                        type="checkbox" name="permission[]"
                                                                        value="{{ $permission->id }}"
                                                                        data-group="{{ $groupName }}"
                                                                        id="permission_{{ $permission->id }}"
                                                                        {{ in_array($permission->id, old('permission', [])) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="permission_{{ $permission->id }}"
                                                                        title="{{ $permission->name }}">
                                                                        {{ $permission->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @error('permission')
                                <div class="alert alert-danger mt-3">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror

                            <!-- Botones -->
                            <div class="d-flex justify-content-end mt-4">
                                <a class="btn btn-secondary btn-sm mx-2" href="{{ route('roles.index') }}">
                                    <i class="fa-solid fa-arrow-left"></i> Regresar
                                </a>
                                <button class="btn btn-primary btn-sm mx-2" type="submit">
                                    <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center mt-4">
                <i class="fa-solid fa-triangle-exclamation fa-2x mb-3"></i>
                <h5>No tienes permisos para crear roles</h5>
                <p class="mb-0">Contacta al administrador si necesitas acceso a esta función.</p>
            </div>
        @endcan
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.select-all').forEach(button => {
                button.addEventListener('click', function() {
                    const group = this.getAttribute('data-group');
                    const checkboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    
                    checkboxes.forEach(cb => {
                        cb.checked = !allChecked;
                    });
                    
                    this.innerHTML = !allChecked ? 
                        '<i class="fa-solid fa-check"></i> Todos' : 
                        '<i class="fa-solid fa-times"></i> Ninguno';
                });
            });

            document.getElementById('selectAllGlobal').addEventListener('click', function() {
                document.querySelectorAll('.permission-checkbox').forEach(cb => {
                    cb.checked = true;
                });
                document.querySelectorAll('.select-all').forEach(btn => {
                    btn.innerHTML = '<i class="fa-solid fa-times"></i> Ninguno';
                });
            });

            document.getElementById('deselectAllGlobal').addEventListener('click', function() {
                document.querySelectorAll('.permission-checkbox').forEach(cb => {
                    cb.checked = false;
                });
                document.querySelectorAll('.select-all').forEach(btn => {
                    btn.innerHTML = '<i class="fa-solid fa-check"></i> Todos';
                });
            });

            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const checkedPermissions = document.querySelectorAll('.permission-checkbox:checked');
                if (checkedPermissions.length === 0) {
                    e.preventDefault();
                    alert('Debe seleccionar al menos un permiso para el rol.');
                    return false;
                }
            });

            function updateSelectedCount() {
                const totalChecked = document.querySelectorAll('.permission-checkbox:checked').length;
                const totalPermissions = document.querySelectorAll('.permission-checkbox').length;
                console.log(`Permisos seleccionados: ${totalChecked}/${totalPermissions}`);
            }

            document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            updateSelectedCount();
        });
    </script>
@endpush