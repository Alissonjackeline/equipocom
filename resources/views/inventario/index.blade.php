@extends('template')
@section('title', 'Inventario')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')

    <div class="container-fluid">
        <div class="row pt-3">
            <div class="col-lg-8">

                <!-- CARD PRINCIPAL -->
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

                    <!-- FILTROS -->
                    <form action="{{ route('inventario.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" for="tipo_id">Tipo de equipo:</label>
                            <select class="form-control selectpicker show-tick" data-size="5" data-live-search="true"
                                id="tipo_id" name="tipo_id">
                                <option value="">Todos los tipos</option>
                                @foreach ($equipmentTypes as $type)
                                    <option value="{{ $type->idEquipmentType }}"
                                        {{ request('tipo_id') == $type->idEquipmentType ? 'selected' : '' }}>
                                        {{ $type->Name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold" for="estado_id">Estado:</label>
                            <select class="form-control selectpicker show-tick" data-size="5" data-live-search="true"
                                id="estado_id" name="estado_id">
                                <option value="">Todos los estados</option>
                                <option value="1" {{ request('estado_id') == '1' ? 'selected' : '' }}>Disponible
                                </option>
                                <option value="2" {{ request('estado_id') == '2' ? 'selected' : '' }}>Por preparar
                                </option>
                                <option value="3" {{ request('estado_id') == '3' ? 'selected' : '' }}>En uso</option>
                                <option value="4" {{ request('estado_id') == '4' ? 'selected' : '' }}>Observación
                                </option>
                                <option value="5" {{ request('estado_id') == '5' ? 'selected' : '' }}>Reparación
                                    Pendiente</option>
                                <option value="6" {{ request('estado_id') == '6' ? 'selected' : '' }}>No devuelto
                                </option>
                                <option value="7" {{ request('estado_id') == '7' ? 'selected' : '' }}>Pérdida-Robo
                                </option>
                                <option value="8" {{ request('estado_id') == '8' ? 'selected' : '' }}>De baja</option>
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-primary"><i class="fa-solid fa-filter"></i> Filtrar</button>
                        </div>
                    </form>

                    <div class="row pt-3">
                        <div class="col-lg-12">

                            <x-data-table :columns="[
                                ['label' => 'TIPO'],
                                ['label' => 'INFORMACIÓN DEL EQUIPO'],
                                ['label' => 'DESCRIPCIÓN/IMAGEN', 'class' => 'text-center'],
                                ['label' => 'ESTADO', 'class' => 'text-center'],
                                ['label' => 'PROVEEDOR', 'class' => 'text-center'],
                                ['label' => 'PRECIO', 'class' => 'text-center'],
                                ['label' => 'ACCIONES', 'class' => 'text-center'],
                            ]" table-id="example">

                                @foreach ($equipments as $equipment)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info text-white">
                                                {{ $equipment->equipmentType->Name }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="mb-1"><span class="info-label">Código Patrimonial</span>
                                                <span class="info-value">{{ $equipment->CodigoPatri }}</span>
                                            </div>
                                            <div class="mb-1"><span class="info-label">Serie</span>
                                                <span class="info-value">{{ $equipment->Series }}</span>
                                            </div>
                                            <div class="mb-1"><span class="info-label">Modelo</span>
                                                <span class="info-value">{{ $equipment->Model }}</span>
                                            </div>
                                            <div><span class="info-label">Marca</span>
                                                <span class="info-value">{{ $equipment->Brand }}</span>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-danger btn-circle action-btn" data-bs-toggle="modal"
                                                data-bs-target="#modaldes{{ $equipment->idEquipment }}">
                                                <i class="fa-solid fa-message"></i>
                                            </button>

                                            @if ($equipment->Imagen)
                                                <button class="btn btn-dark btn-circle action-btn" data-bs-toggle="modal"
                                                    data-bs-target="#modalimg{{ $equipment->idEquipment }}">
                                                    <i class="fa-solid fa-images"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <x-btn-descripcion id="modaldes{{ $equipment->idEquipment }}" title="DESCRIPCIÓN"
                                            size="modal-sm">
                                            <p>{{ $equipment->Description }}</p>
                                        </x-btn-descripcion>

                                        <x-btn-imagen id="modalimg{{ $equipment->idEquipment }}" title="IMAGEN"
                                            size="modal-sm">
                                            <img src="{{ $equipment->image_url }}" class="img-fluid"
                                                alt="Imagen del equipo">
                                        </x-btn-imagen>

                                        <td class="text-center">
    <span class="badge bg-{{ $equipment->status_class }}">
        <i class="fa-solid {{ $equipment->status_icon }} me-1"></i>{{ $equipment->status_text }}
    </span>
</td>

                                        <td class="text-center">
                                            <span class="badge bg-purple text-white">
                                                <i class="fa-solid fa-user me-1"></i>
                                                {{ $equipment->supplier->Company_name }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            S/ {{ number_format($equipment->Price, 2) }}
                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalEditar{{ $equipment->idEquipment }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalEliminar{{ $equipment->idEquipment }}">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- EDITAR -->
                                    <x-modal-editar-equipo id="modalEditar{{ $equipment->idEquipment }}" :equipment="$equipment"
                                        :equipmentTypes="$equipmentTypes" :suppliers="$suppliers" />

                                    <!-- ELIMINAR -->
                                    <x-modal-eliminar-equipo id="modalEliminar{{ $equipment->idEquipment }}"
                                        :equipment="$equipment" />
                                @endforeach
                            </x-data-table>
                        </div>

                    </div>

                </x-card-header>
            </div>
            <div class="col-lg-4">
    <x-card-header title="ESTADÍSTICAS POR ESTADO" icon="fa-solid fa-chart-pie">
        <div class="row g-2">
            @php
                $estados = [
                    1 => ['nombre' => 'Disponible', 'icono' => 'fa-circle-check', 'color' => 'success'],
                    2 => ['nombre' => 'Por preparar', 'icono' => 'fa-hourglass-half', 'color' => 'info'],
                    3 => ['nombre' => 'En uso', 'icono' => 'fa-laptop', 'color' => 'primary'],
                    4 => ['nombre' => 'Observación', 'icono' => 'fa-eye', 'color' => 'warning'],
                    5 => ['nombre' => 'R Pendiente', 'icono' => 'fa-tools', 'color' => 'secondary'],
                    6 => ['nombre' => 'No devuelto', 'icono' => 'fa-exclamation-triangle', 'color' => 'danger'],
                    7 => ['nombre' => 'Perdida-Robo', 'icono' => 'fa-shield-alt', 'color' => 'dark'],
                    8 => ['nombre' => 'De baja', 'icono' => 'fa-ban', 'color' => 'secondary'],
                ];
                $conteoEstados = [];
                foreach ($estados as $key => $estado) {
                    $conteoEstados[$key] = $equipmentsAll->where('status', $key)->count();
                }
            @endphp

            @foreach ($estados as $key => $estado)
                <div class="col-6">
                    <div class="card border-0 shadow-sm mb-2">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="shrink-0">
                                    <span class="badge bg-{{ $estado['color'] }} p-2">
                                        <i class="fa-solid {{ $estado['icono'] }} fa-lg"></i>
                                    </span>
                                </div>
                                <div class="grow ms-3">
                                    <h6 class="mb-0 fw-semibold text-{{ $estado['color'] }}">
                                        {{ $estado['nombre'] }}
                                    </h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fs-4 fw-bold text-dark">{{ $conteoEstados[$key] }}</span>
                                        <small class="text-muted">equipos</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-12">
                <div class="card border-primary border-2 shadow-sm mt-2">
                    <div class="card-body p-3 text-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa-solid fa-cubes fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold text-primary">TOTAL GENERAL</h6>
                                <span class="fs-3 fw-bold text-dark">{{ $equipmentsAll->count() }}</span>
                                <small class="text-muted d-block">equipos registrados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </x-card-header>
</div>

        </div>
    </div>
    </div>
    </div>
@endsection

@push('js')
@endpush
