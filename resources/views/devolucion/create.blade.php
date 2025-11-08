@extends('template')
@section('title', 'Crear devolucion')

@push('css')
    <link href="{{ asset('Css/historial.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header title="AGREGAR DEVOLUCION" icon="fa-solid fa-repeat" :buttons="[
                [
                    'text' => 'Devoluciones',
                    'icon' => 'fa-solid fa-repeat',
                    'route' => route('devolucion.index'),
                    'variant' => 'persona',
                ],
            ]">

                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="jefe_id">
                                Jefe de Area:
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="jefe_id" name="jefe_id" required>
                                <option value="" selected disabled>Seleccionar jefe de area</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-primary">
                                <i class="fa-solid fa-filter"></i>Filtrar
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Datos del Asignado -->
                <div class="card pt-3" id="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2"
                        id="encabezado">
                        <h6 class="mb-0 flex-md-grow-1 text-center"> DATOS DEL ASIGNADO
                        </h6>
                    </div>
                    <div class="card-body fondocard">
                        <div class="row justify-content-center g-3">
                            <!-- DNI -->
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-address-card text-secondary"></i>
                                    </div>
                                    <div class="info-label small">7777777</div>
                                    <div class="info-value small text-muted">DNI</div>
                                </div>
                            </div>

                            <!-- Nombre -->
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-user-tag text-secondary"></i>
                                    </div>
                                    <div class="info-label small text-truncate" title="JUAN SANCHEZ CASTILLO">JUAN SANCHEZ
                                        CASTILLO</div>
                                    <div class="info-value small text-muted">NOMBRE COMPLETOS</div>
                                </div>
                            </div>

                            <!-- Cargo -->
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-briefcase text-secondary"></i>
                                    </div>
                                    <div class="info-label small text-truncate" title="JEFE">JEFE</div>
                                    <div class="info-value small text-muted">CARGO</div>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-phone text-secondary"></i>
                                    </div>
                                    <div class="info-label small">99999999</div>
                                    <div class="info-value small text-muted">TELEFONO</div>
                                </div>
                            </div>

                            <!-- Área - Sede -->
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <div class="info-circle mx-auto mb-2">
                                        <i class="fa-solid fa-building text-secondary"></i>
                                    </div>
                                    <div class="info-label small text-truncate" title="OFICINA DE IMAGEN INSTITUCIONAL">
                                        OFICINA DE IMAGEN INSTITUCIONAL</div>
                                    <div class="info-label small text-truncate" title="SEDE PRINCIPAL">SEDE PRINCIPAL</div>
                                    <div class="info-value small text-muted">AREA - SEDE</div>
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="info-item text-center">
                                    <span class="badge bg-success mb-2">
                                        <i class="fa-solid fa-circle-check me-1"></i>Activo
                                    </span>
                                    <div class="info-value small text-muted">ESTADO</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pt-2">
                    <!-- Tarjeta 1 -->
                    <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-3">
                        <div class="card h-100" id="card">
                            <h6 class="card-header text-center" id="encabezado">
                                EQUIPO ASIGNADO
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
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div
                                            class="pt-2 d-flex gap-2 flex-wrap justify-content-center justify-content-sm-start">
                                            <button class="btn btn-primary btn-circle action-btn" data-bs-toggle="modal"
                                                data-bs-target="#modaldocu" title="Ver Documento">
                                                <i class="fa-solid fa-file-lines"></i>
                                            </button>
                                            <button class="btn btn-danger btn-circle action-btn" title="Ver descripción"
                                                data-bs-toggle="modal" data-bs-target="#modaldes">
                                                <i class="fa-solid fa-message"></i>
                                            </button>
                                            <button class="btn btn-dark btn-circle action-btn" title="Ver imágenes"
                                                data-bs-toggle="modal" data-bs-target="#modalimg">
                                                <i class="fa-solid fa-images"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">

                                        <div class="row justify-content-center g-3">

                                            <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                <div class="info-item text-center">
                                                    <div class="info-circle mx-auto mb-2">
                                                        <i class="fa-solid fa-laptop text-secondary"></i>
                                                    </div>
                                                    <div class="info-label small">LAPTOP</div>
                                                    <div class="info-value small text-muted">TIPO</div>
                                                </div>
                                            </div>

                                            <!-- Código Patrimonial -->
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                <div class="info-item text-center">
                                                    <div class="info-circle mx-auto mb-2">
                                                        <i class="fa-solid fa-hashtag text-secondary"></i>
                                                    </div>
                                                    <div class="info-label small text-truncate" title="888ARFGRFGRF">
                                                        888ARFGRFGRF</div>
                                                    <div class="info-value small text-muted">CÓDIGO PATRIMONIAL</div>
                                                </div>
                                            </div>

                                            <!-- Serie -->
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                <div class="info-item text-center">
                                                    <div class="info-circle mx-auto mb-2">
                                                        <i class="fa-solid fa-barcode text-secondary"></i>
                                                    </div>
                                                    <div class="info-label small text-truncate" title="888ARFGRFGRF">
                                                        888ARFGRFGRF</div>
                                                    <div class="info-value small text-muted">SERIE</div>
                                                </div>
                                            </div>

                                            <!-- Modelo -->
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                <div class="info-item text-center">
                                                    <div class="info-circle mx-auto mb-2">
                                                        <i class="fa-solid fa-desktop text-secondary"></i>
                                                    </div>
                                                    <div class="info-label small">MODELO</div>
                                                    <div class="info-value small text-muted">MODELO</div>
                                                </div>
                                            </div>

                                            <!-- Proveedor -->
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                <div class="info-item text-center">
                                                    <div class="info-circle mx-auto mb-2">
                                                        <i class="fa-solid fa-user text-secondary"></i>
                                                    </div>
                                                    <div class="info-label small">PROVEEDOR</div>
                                                    <div class="info-value small text-muted">PROVEEDOR</div>
                                                </div>
                                            </div>

                                            <!-- Marca -->
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                <div class="info-item text-center">
                                                    <div class="info-circle mx-auto mb-2">
                                                        <i class="fa-solid fa-tag text-secondary"></i>
                                                    </div>
                                                    <div class="info-label small">MARCA</div>
                                                    <div class="info-value small text-muted">MARCA</div>
                                                </div>
                                            </div>

                                            <!-- Precio -->
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                <div class="info-item text-center">
                                                    <div class="info-circle mx-auto mb-2">
                                                        <i class="fa-solid fa-dollar-sign text-secondary"></i>
                                                    </div>
                                                    <div class="info-label small">S/ 1,500.00</div>
                                                    <div class="info-value small text-muted">PRECIO</div>
                                                </div>
                                            </div>

                                            <!-- Estado -->
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                <div class="info-item text-center">
                                                    <span class="badge bg-success mb-2">
                                                        <i class="fa-solid fa-circle-check me-1"></i>Disponible
                                                    </span>
                                                    <div class="info-value small text-muted">ESTADO</div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary mx-2" data-bs-toggle="modal"
                                                data-bs-target="#devolver"><i class="fa-solid fa-repeat"></i>
                                                Devolver / Observar
                                            </button>
                                            <x-devolver id="devolver" title="Devolver/Observacion" size="modal-md">
                                                <form action="" method="POST">
                                                    <div class="row g-3">
                                                        <div class="col-md-12">
                                                            <label class="form-label fw-semibold" for="fecha">
                                                                Fecha:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="date" class="form-control" id="fecha"
                                                                name="fecha" required>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label fw-semibold" for="asignado_id">
                                                                Devolvio:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <select class="form-select" id="asignado_id"
                                                                name="asignado_id" required>
                                                                <option value="" selected disabled>Seleccionar
                                                                    asignado</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label fw-semibold" for="estado">
                                                                Estado:
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <select class="form-select" id="estado" name="estado"
                                                                required>
                                                                <option value="" selected disabled>Seleccionar Estado
                                                                </option>
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
                                            </x-devolver>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card-header>
            <x-btn-documento id="modaldocu" title="DOCUMENTO" size="modal-md">
                <embed src="https://www.temarium.com/serlibre/recursos/apuntes/Plan.Dis.Sistemas.Informac.pdf" type="application/pdf" width="100%" height="500px" />
            </x-btn-documento>
            <x-btn-descripcion id="modaldes" title="DESCRIPCION" size="modal-md">
            </x-btn-descripcion>
            <x-btn-imagen id="modalimg" title="IMAGEN" size="modal-md">
    <img src="https://humanidades.com/wp-content/uploads/2018/12/sistema-informatico-1-e1585504699254.jpg" class="img-fluid" alt="Imagen de ejemplo">
</x-btn-imagen>



        </div>
    </div>
    </div>
@endsection

@push('js')
@endpush
