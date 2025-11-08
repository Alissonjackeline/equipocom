@extends('template')
@section('title', 'Crear inventario')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header 
                title="AGREGAR EQUIPO" 
                icon="fa-solid fa-computer"
                :buttons="[
                    [
                        'text' => 'Inventario',
                        'icon' => 'fa-solid fa-computer',
                        'route' => route('inventario.index'),
                        'variant' => 'persona'
                    ],
                    [
                        'text' => 'Historial',
                        'icon' => 'fa-solid fa-magnifying-glass me-1',
                        'route' => route('inventario.historial'),
                        'variant' => 'secondary'
                    ]
                ]">
                
                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="tipo_id">
                                Tipo de equipo:
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="tipo_id" name="tipo_id" required>
                                <option value="" selected disabled>Seleccionar tipo de equipo</option>
                                <option value="1">Computadora</option>
                                <option value="2">Laptop</option>
                                <option value="3">Monitor</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="codigo">
                                Codigo patrimonial:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="codigo" name="codigo"
                                placeholder="7278992025" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="serie">
                                Serie:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="serie" name="serie"
                                placeholder="SNFH57392K" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="modelo">
                                Modelo:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="modelo" name="modelo"
                                placeholder="SNF-555" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="marca">
                                Marca:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="marca" name="marca"
                                placeholder="SNF-555" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="proveedor_id">
                                Proveedor:
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="proveedor_id" name="proveedor_id" required>
                                <option value="" selected disabled>Seleccionar proveedor</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="precio">
                                Precio:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="precio" name="precio" placeholder="S/"
                                required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="estado">
                                Estado:
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="" selected disabled>Seleccionar proveedor</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="descripcion">
                                Descripcion:
                                <span class="text-danger">*</span>
                            </label>
                            <textarea type="text" class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="imagen">
                                Imagen:
                            </label>
                            <input class="form-control" type="file" id="imagen">
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