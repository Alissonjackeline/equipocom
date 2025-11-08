@extends('template')
@section('title', 'Inventario')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header title="INVENTARIO DE EQUIPOS" icon="fa-solid fa-computer" :buttons="[
                [
                    'text' => 'Agregar',
                    'icon' => 'fa-solid fa-circle-plus me-1',
                    'route' => route('inventario.create'),
                    'variant' => 'persona',
                ],
                [
                    'text' => 'Historial',
                    'icon' => 'fa-solid fa-magnifying-glass me-1',
                    'route' => route('inventario.historial'),
                    'variant' => 'secondary',
                ],
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
                            <label class="form-label fw-semibold" for="estado_id">
                                Estado:
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="estado_id" name="estado_id" required>
                                <option value="" selected disabled>Seleccionar estado</option>
                                <option value="1">Disponible</option>
                                <option value="2">En uso</option>
                                <option value="3">Mantenimiento</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-primary">
                                <i class="fa-solid fa-filter"></i>Filtrar
                            </button>
                        </div>
                    </div>
                </form>



                <div class="row pt-3">
                    <div class="col-lg-12">
                        <x-data-table :columns="[
                            ['label' => 'TIPO'],
                            ['label' => 'INFORMACIÓN DEL EQUIPO'],
                            ['label' => 'DESCRIPCION/IMAGEN', 'class' => 'text-center'],
                            ['label' => 'ESTADO', 'class' => 'text-center'],
                            ['label' => 'PROVEEDOR', 'class' => 'text-center'],
                            ['label' => 'PRECIO', 'class' => 'text-center'],
                            ['label' => 'ACCIONES', 'class' => 'text-center'],
                        ]" table-id="example">

                            <tr>
                                <td>
                                    <span class="badge bg-info text-white">PC</span>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <span class="info-label">Código Patrimonial</span>
                                        <span class="info-value">CP-2024-001</span>
                                    </div>
                                    <div class="mb-1">
                                        <span class="info-label">Serie</span>
                                        <span class="info-value">SN123456789</span>
                                    </div>
                                    <div class="mb-1">
                                        <span class="info-label">Modelo</span>
                                        <span class="info-value">HP EliteDesk 800 G5</span>
                                    </div>
                                    <div>
                                        <span class="info-label">Marca</span>
                                        <span class="info-value">HP</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-circle action-btn" title="Ver descripción"
                                        data-bs-toggle="modal" data-bs-target="#modaldes">
                                        <i class="fa-solid fa-message"></i>
                                    </button>
                                    <button class="btn btn-dark btn-circle action-btn" title="Ver imágenes"
                                        data-bs-toggle="modal" data-bs-target="#modalimg">
                                        <i class="fa-solid fa-images"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">
                                        <i class="fa-solid fa-circle-check me-1"></i>Disponible
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-purple text-white">
                                        <i class="fa-solid fa-user me-1"></i>Pedro Timana
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="info-value">S/ 2,500.00</div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEditar" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm action-btn" title="Eliminar">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>

                        </x-data-table>
                        <x-modal-base id="modalEditar" title="Editar Inventario" size="modal-md">
                            <form action="" method="POST">
                                <div class="row g-3">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="codigo">
                                            Codigo patrimonial:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="codigo" name="codigo"
                                            placeholder="7278992025" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="serie">
                                            Serie:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="serie" name="serie"
                                            placeholder="SNFH57392K" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="modelo">
                                            Modelo:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="modelo" name="modelo"
                                            placeholder="SNF-555" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="marca">
                                            Marca:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="marca" name="marca"
                                            placeholder="SNF-555" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="proveedor_id">
                                            Proveedor:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="proveedor_id" name="proveedor_id" required>
                                            <option value="" selected disabled>Seleccionar proveedor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="precio">
                                            Precio:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="precio" name="precio"
                                            placeholder="S/" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="estado">
                                            Estado:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="estado" name="estado" required>
                                            <option value="" selected disabled>Seleccionar proveedor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold" for="descripcion">
                                            Descripcion:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea type="text" class="form-control" id="descripcion" name="descripcion" required></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold" for="imagen">
                                            Imagen:
                                        </label>
                                        <input class="form-control" type="file" id="imagen">
                                    </div>
                                </div>
                            </form>
                        </x-modal-base>

                        <x-btn-descripcion id="modaldes" title="DESCRIPCION" size="modal-md">
                        </x-btn-descripcion>
                        <x-btn-imagen id="modalimg" title="IMAGEN" size="modal-md">
                            <img src="https://humanidades.com/wp-content/uploads/2018/12/sistema-informatico-1-e1585504699254.jpg"
                                class="img-fluid" alt="Imagen de ejemplo">
                        </x-btn-imagen>
                    </div>
                </div>
        </div>
        </x-card-header>
    </div>
    </div>
@endsection

@push('js')
@endpush
