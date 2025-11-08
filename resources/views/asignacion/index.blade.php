@extends('template')
@section('title', 'Asignaciones')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header title="LISTAR ASIGNACIONES" icon="fa-solid fa-file-circle-plus" :buttons="[
                [
                    'text' => 'Agregar',
                    'icon' => 'fa-solid fa-circle-plus me-1',
                    'route' => route('asignacion.create'),
                    'variant' => 'persona',
                ],
            ]">

                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label fw-semibold" for="desde">
                                Desde:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="desde" name="desde" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold" for="hasta">
                                Hasta:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="hasta" name="hasta" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="area_id">
                                Area
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="area_id" name="area_id" required>
                                <option value="" selected disabled>Seleccionar tipo de equipo</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="usuario_id">
                                Usuario
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="usuario_id" name="usuario_id" required>
                                <option value="" selected disabled>Seleccionar estado</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-primary">
                                <i class="fa-solid fa-filter"></i>Filtrar
                            </button>
                        </div>
                    </div>
                </form>

            </x-card-header>
        </div>

        <div class="row pt-3">
            <div class="col-lg-12">
                <x-data-table :columns="[
                    ['label' => 'FECHA ASIGNACION', 'class' => 'text-center'],
                    ['label' => 'EQUIPO', 'class' => 'text-center'],
                    ['label' => 'ASIGNADO', 'class' => 'text-center'],
                    ['label' => 'DOCUMENTO/COMENTARIO/IMAGEN', 'class' => 'text-center'],
                    ['label' => 'ESTADO', 'class' => 'text-center'],
                    ['label' => 'USUARIO', 'class' => 'text-center'],
                    ['label' => 'ACCIONES', 'class' => 'text-center'],
                ]" table-id="example">

                    <!-- Aquí van las filas de la tabla -->
                    <tr>
                        <td class="text-center">
                            <span class="badge bg-info text-white">17/05/2025</span>
                        </td>
                        <td>
                            <div class="mb-1">
                                <span class="info-label">Tipo</span>
                                <span class="info-value">laptop</span>
                            </div>
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
                            <div class="mb-1">
                                <span class="info-asigtable">NOMBRES Y APELLIDOS</span><br />
                                <span class="info-asigtable">DNI</span><br />
                                <span class="info-asigtable">OFICINA DE ADMINISTRACION</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-primary btn-circle action-btn" data-bs-toggle="modal"
                                data-bs-target="#modaldocu" title="Ver Documento">
                                <i class="fa-solid fa-file-lines"></i>
                            </button>
                            <button class="btn btn-danger btn-circle action-btn" title="Ver descripción"
                                data-bs-toggle="modal" data-bs-target="#modaldes">
                                <i class="fa-solid fa-message"></i>
                            </button>
                            <button class="btn btn-dark btn-circle action-btn" title="Ver imágenes" data-bs-toggle="modal"
                                data-bs-target="#modalimg">
                                <i class="fa-solid fa-images"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success">
                                <i class="fa-solid fa-circle-check me-1"></i>En uso
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-purple text-white">
                                <i class="fa-solid fa-user me-1"></i>JUAN C
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar"
                                title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <button class="btn btn-danger btn-sm action-btn" title="Eliminar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                        </td>
                    </tr>

                </x-data-table>
                <x-modal-base id="modalEditar" title="Editar Asignacion" size="modal-md">
                    <form action="" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="fecha">
                                    Fecha:
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="asignado_id">
                                    Asignado:
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="asignado_id" name="asignado_id" required>
                                    <option value="" selected disabled>Seleccionar asignado</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="equipo_id">
                                    Equipo:
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="equipo_id" name="equipo_id" required>
                                    <option value="" selected disabled>Seleccionar equipo</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="estado">
                                    Estado:
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="" selected disabled>Seleccionar Estado</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" for="comentario">
                                    Comentario:
                                </label>
                                <textarea type="text" class="form-control" id="comentario" name="comentario"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" for="imagen">
                                    Imagen:
                                </label>
                                <input class="form-control" type="file" id="imagen">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" for="documento">
                                    Documento:<span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="file" id="documento">
                            </div>
                        </div>
                    </form>
                </x-modal-base>
                <x-btn-documento id="modaldocu" title="DOCUMENTO" size="modal-md">
                    <embed src="https://www.temarium.com/serlibre/recursos/apuntes/Plan.Dis.Sistemas.Informac.pdf"
                        type="application/pdf" width="100%" height="500px" />
                </x-btn-documento>
                <x-btn-descripcion id="modaldes" title="DESCRIPCION" size="modal-md">
                </x-btn-descripcion>
                <x-btn-imagen id="modalimg" title="IMAGEN" size="modal-md">
                    <img src="https://humanidades.com/wp-content/uploads/2018/12/sistema-informatico-1-e1585504699254.jpg"
                        class="img-fluid" alt="Imagen de ejemplo">
                </x-btn-imagen>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('js')
@endpush
