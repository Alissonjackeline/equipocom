@extends('template')
@section('title', 'Crear asignacion')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header 
                title="CREAR ASIGNACION" 
                icon="fa-solid fa-file-circle-plus"
                :buttons="[
                    [
                        'text' => 'Asignaciones',
                        'icon' => 'fa-solid fa-file-circle-plus',
                        'route' => route('asignacion.index'),
                        'variant' => 'persona'
                    ]
                ]">
                
                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="fecha">
                                Fecha:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="asignado_id">
                                Asignado:
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="asignado_id" name="asignado_id" required>
                                <option value="" selected disabled>Seleccionar asignado</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="equipo_id">
                                Equipo:
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="equipo_id" name="equipo_id" required>
                                <option value="" selected disabled>Seleccionar equipo</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="estado">
                                Estado:
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="" selected disabled>Seleccionar Estado</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="usuario_id">
                                Usuario:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="usuario_id" name="usuario_id" disabled required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="comentario">
                                Comentario:
                            </label>
                            <textarea type="text" class="form-control" id="comentario" name="comentario"></textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="imagen">
                                Imagen:
                            </label>
                            <input class="form-control" type="file" id="imagen">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="documento">
                                Documento:<span class="text-danger">*</span>
                            </label>
                            <input class="form-control" type="file" id="documento">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end pt-2">
                        <button class="btn btn-secondary mx-2" type="reset">CANCELAR
                        </button>
                        <button class="btn btn-primary mx-2" type="submit"><i class="fa-solid fa-floppy-disk"></i>
                            GUARDAR
                        </button>
                    </div>
                </form>
                
            </x-card-header>
        </div>
    </div>


@endsection

@push('js')
@endpush