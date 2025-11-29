@extends('template')
@section('title', 'Historial')

@push('css')
    <link href="{{ asset('Css/historial.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        @can('Historial-Inventario')
            <div class="col-12 pt-4">
                <div class="card shadow-sm border-0">
                    <x-card-header title="HISTORIAL DE EQUIPOS" icon="fa-solid fa-computer">

                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-semibold" for="codigo">
                                        Codigo patrimonial:
                                    </label>
                                    <input type="text" class="form-control" id="codigo" name="codigo"
                                        placeholder="Escribe codigo patrimonial" required>
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label class="form-label fw-semibold" for="serie">
                                        Serie:
                                    </label>
                                    <input type="text" class="form-control" id="serie" name="serie"
                                        placeholder="Escribir serie" required>
                                </div>
                                <div class="col-12 col-md-4 col-lg-2 d-flex align-items-end">
                                    <button class="btn btn-primary ">
                                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="row pt-3">
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-laptop text-secondary"></i>
                                    </div>
                                    <div class="info-label">LAPTOP</div>
                                    <div class="info-value">TIPO</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-hashtag text-secondary"></i>
                                    </div>
                                    <div class="info-label text-truncate" title="888ARFGRFGRF">888ARFGRFGRF</div>
                                    <div class="info-value">CÓDIGO PATRIMONIAL</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-barcode text-secondary"></i>
                                    </div>
                                    <div class="info-label text-truncate" title="888ARFGRFGRF">888ARFGRFGRF</div>
                                    <div class="info-value">SERIE</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-desktop text-secondary"></i>
                                    </div>
                                    <div class="info-label">MODELO</div>
                                    <div class="info-value">MODELO</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-user text-secondary"></i>
                                    </div>
                                    <div class="info-label">PROVEEDOR</div>
                                    <div class="info-value">PROVEEDOR</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-tag text-secondary"></i>
                                    </div>
                                    <div class="info-label">MARCA</div>
                                    <div class="info-value">MARCA</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-dollar-sign text-secondary"></i>
                                    </div>
                                    <div class="info-label">S/ 1,500.00</div>
                                    <div class="info-value">PRECIO</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <span class="badge bg-success mb-2">
                                        <i class="fa-solid fa-circle-check me-1"></i>Disponible
                                    </span>
                                    <div class="info-value">ESTADO</div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <button class="btn btn-primary btn-circle action-btn" title="Ver descripción">
                                        <i class="fa-solid fa-file-lines"></i>
                                    </button>
                                    <button class="btn btn-dark btn-circle action-btn" title="Ver imágenes">
                                        <i class="fa-solid fa-images"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row pt-2">
                            <div class="col-12 col-lg-6 col-xl-4">
                                <div class="card h-100" id="card">
                                    <h6 class="card-header text-center" id="encabezado">
                                        ASIGNACION / DEVOLUCION
                                    </h6>
                                    <div class="card-body fondocard">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <span class="info-span d-block mb-2">
                                                    <i class="fa-solid fa-user"></i>&nbsp;USUARIO: Nombre del usuario
                                                </span>
                                                <span class="info-span d-block mb-2">
                                                    <i class="fa-solid fa-calendar-days"></i>&nbsp;FECHA DE ENTREGA:
                                                    12/08/2025 09:05:00
                                                </span>
                                                <span class="info-span d-block mb-2">
                                                    <i class="fa-solid fa-location-dot"></i>&nbsp;Nombre de encargado
                                                    <br />Nombre de area
                                                </span>
                                                <span class="info-span d-block mb-2">
                                                    ESTADO: <span class="badge bg-success">
                                                        <i class="fa-solid fa-circle-check me-1"></i>Disponible
                                                    </span>
                                                </span>
                                                <div class="pt-2 d-flex gap-2 flex-wrap">
                                                    <button class="btn btn-primary btn-circle action-btn"
                                                        title="Ver Documento">
                                                        <i class="fa-solid fa-file-lines"></i>
                                                    </button>
                                                    <button class="btn btn-dark btn-circle action-btn" title="Ver imágenes">
                                                        <i class="fa-solid fa-images"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-circle action-btn"
                                                        title="Ver descripción">
                                                        <i class="fa-solid fa-message"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <span class="info-span d-block mb-2">
                                                    <i class="fa-solid fa-user"></i>&nbsp;USUARIO: Nombre del usuario
                                                </span>
                                                <span class="info-span d-block mb-2">
                                                    <i class="fa-solid fa-calendar-days"></i>&nbsp;FECHA DE DEVOLUCION:
                                                    12/08/2025 09:05:00
                                                </span>
                                                <span class="info-span d-block mb-2">
                                                    <i class="fa-solid fa-repeat"></i>&nbsp;DEVOLVIO: Si
                                                </span>
                                                <span class="info-span d-block mb-2">
                                                    ESTADO: <span class="badge bg-success">
                                                        <i class="fa-solid fa-circle-check me-1"></i>Disponible
                                                    </span>
                                                </span>
                                                <div class="pt-2 d-flex gap-2 flex-wrap">
                                                    <button class="btn btn-info btn-circle action-btn" title="Ver Motivo">
                                                        <i class="fa-solid fa-hand-holding"></i>
                                                    </button>
                                                    <button class="btn btn-primary btn-circle action-btn"
                                                        title="Ver Documento">
                                                        <i class="fa-solid fa-file-lines"></i>
                                                    </button>
                                                    <button class="btn btn-dark btn-circle action-btn" title="Ver imágenes">
                                                        <i class="fa-solid fa-images"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-circle action-btn"
                                                        title="Ver descripción">
                                                        <i class="fa-solid fa-message"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </x-card-header>
                </div>
            </div>
        @endcan
    </div>
@endsection

@push('js')
@endpush
