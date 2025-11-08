@extends('template')
@section('title', 'Agregar Rol')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header title="AGREGAR ROL" icon="fa-solid fa-circle-plus me-1" :buttons="[
                [
                    'text' => 'Roles',
                    'icon' => 'fa-solid fa-address-card me-1',
                    'route' => route('rol.index'),
                    'variant' => 'persona',
                ],
            ]">
                <form action="" method="" class="row">
                    <div class="col-md-4 mb-3">
                        <label for="document" class="form-label fw-semibold">
                            Rol:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="document" id="document" class="form-control" placeholder="Ingrese rol"
                            required>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-success btn-sm me-2" id="selectAllGlobal">
                            <i class="fa-solid fa-check-double"></i> Seleccionar todos
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" id="deselectAllGlobal">
                            <i class="fa-solid fa-ban"></i> Deseleccionar todos
                        </button>
                    </div>

                    <h6 class="fw-bold">Permisos: <span class="text-danger">*</span></h6>

                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="border rounded shadow-sm h-100">
                                <!-- Encabezado -->
                                <div class="d-flex justify-content-between align-items-center text-white px-3 py-2"
                                    id="encabezado">
                                    <strong>Catalogo</strong>
                                    <a href="javascript:void(0);" class="btn btn-success btn-sm select-all"
                                        data-group="CATALOGO">
                                        <i class="fa-solid fa-check"></i> Seleccionar todos
                                    </a>
                                </div>

                                <div class="p-3">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-check mb-1">
                                                <input class="form-check-input permission-checkbox" type="checkbox"
                                                    name="permission[]" value="1" data-group="CATALOGO"
                                                    id="permission_1">
                                                <label class="form-check-label" for="permission_1">Ver-Catalogo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
    <button class="btn btn-secondary me-2" type="reset">Cancelar
    </button>
    <button class="btn btn-primary" type="submit">
        <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
    </button>
</div>

                </form>

            </x-card-header>
        </div>
    </div>


@endsection

@push('js')
@endpush
