 @extends('template')
 @section('title','Editar Rol')

 @push('css')
 <!-- Datatables -->
 <link href="{{ asset('Css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
 <link href="{{ asset('Css/buttons.bootstrap5.css') }}" rel="stylesheet" />
 @endpush
 @section('content')
 @include('layouts.partials.alert')
 <div class="container-fluid">
    @can('Editar-Rol')
<div class="col-12 pt-4">
    <div class="card shadow-sm border-0">
        <h5 class="card-header text-white" id="encabezado">
            <i class="fa-solid fa-pen-to-square"></i> Editar Rol
        </h5>
        <div class="card-body">
            <form action="{{ route('roles.update', ['role' => $role]) }}" method="post">
                @csrf
                @method('PATCH')

                <!-- Campo Nombre Rol -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="name" class="fw-bold">Rol: <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control"
                               value="{{ old('name', $role->name) }}" required>
                        @error('name')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Botones globales -->
                <div class="mb-3">
                    <button type="button" class="btn btn-success btn-sm me-2" id="selectAllGlobal">
                        <i class="fa-solid fa-check-double"></i> Seleccionar todos
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="deselectAllGlobal">
                        <i class="fa-solid fa-ban"></i> Deseleccionar todos
                    </button>
                </div>

                <!-- Título permisos -->
                <h6 class="fw-bold mb-3">Permisos: <span class="text-danger">*</span></h6>

                <div class="row g-3">
                    @php
                        $groups = [
                            'CATALOGO', 'EMPRESA', 'SEDES', 'AREAS', 'PERIODO', 
                            'DOCUMENTO', 'ROL', 'USUARIO', 'EXPEDIENTE', 'PERFIL', 'HORARIO'
                        ];
                        $rolePermissions = $role->permissions->pluck('id')->toArray();
                    @endphp

                    @foreach ($groups as $group)
                        <div class="col-12 col-md-4">
                            <div class="border rounded shadow-sm h-100">
                                <!-- Encabezado -->
                                <div class="d-flex justify-content-between align-items-center text-white px-3 py-2" id="encabezado">
                                    <strong>{{ ucfirst(strtolower($group)) }}</strong>
                                    <a href="javascript:void(0);" 
                                       class="btn btn-success btn-sm select-all" 
                                       data-group="{{ $group }}">
                                        <i class="fa-solid fa-check"></i> Seleccionar todos
                                    </a>
                                </div>

                                <!-- Lista de permisos -->
                                <div class="p-3">
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                            @if (stripos($permission->name, $group) !== false)
                                                <div class="col-12 col-md-6">
                                                    <div class="form-check mb-1">
                                                        <input class="form-check-input permission-checkbox" 
                                                               type="checkbox" 
                                                               name="permission[]" 
                                                               value="{{ $permission->id }}"
                                                               data-group="{{ $group }}"
                                                               id="permission_{{ $permission->id }}"
                                                               {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
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
                    <small class="text-danger">{{ '*'.$message }}</small>
                @enderror

                <!-- Botones -->
                <div class="d-flex justify-content-end mt-4">
                    <a class="btn btn-secondary btn-sm mx-2" href="{{ route('roles.index') }}">
                        <i class="fa-solid fa-arrow-left"></i> Regresar
                    </a>
                    <button class="btn btn-primary btn-sm mx-2" type="submit">
                        <i class="fa-solid fa-pen-to-square"></i>&nbsp;Modificar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para seleccionar/deseleccionar -->
<script>
    // Botón por grupo
    document.querySelectorAll('.select-all').forEach(link => {
        link.addEventListener('click', function() {
            const group = this.getAttribute('data-group');
            const checkboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        });
    });

    // Botón global seleccionar todos
    document.getElementById('selectAllGlobal').addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
    });

    // Botón global deseleccionar todos
    document.getElementById('deselectAllGlobal').addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
    });
</script>

     @endcan

 </div>
 @endsection

 @push('js')
 <script>
     $(document).ready(function() {
         // Configuración para orientación horizontal en PDF
         var pdfOrientation = "landscape";

         $("#example").DataTable({
             dom: "Bfrtip",
             buttons: [{
                     extend: "csv",
                     text: "CSV",
                 },
                 {
                     extend: "excel",
                     text: "Excel",
                 },
                 {
                     extend: "pdf",
                     text: "PDF",
                 },
             ],
             lengthMenu: [10, 25, 50, 100],
         });
     });
 </script>

 <!-- Datatables -->
 <script src="{{ asset ('js/jquery.dataTables.js') }}"></script>
 <script src="{{ asset ('js/dataTables.bootstrap5.js') }}"></script>
 <script src="{{ asset ('js/dataTables.buttons.js') }}"></script>
 <script src="{{ asset ('js/buttons.bootstrap5.js') }}"></script>
 <script src="{{ asset ('js/buttons.colVis.js') }}"></script>
 <script src="{{ asset ('js/buttons.html5.js') }}"></script>
 <script src="{{ asset ('js/buttons.print.js') }}"></script>
 <script src="{{ asset ('js/jszip.js') }}"></script>
 <script src="{{ asset ('js/pdfmake.js') }}"></script>
 <script src="{{ asset ('js/vfs_fonts.js') }}"></script>
 @endpush