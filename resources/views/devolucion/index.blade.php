@extends('template')
@section('title', 'Devoluciones')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header title="LISTAR DE DEVOLUCIONES" icon="fa-solid fa-file-circle-plus" :buttons="[
                [
                    'text' => 'Agregar',
                    'icon' => 'fa-solid fa-circle-plus me-1',
                    'route' => route('devolucion.create'),
                    'variant' => 'persona',
                ],
            ]">

                <div class="row pt-3">
                    <div class="col-lg-12">
                        <x-data-table :columns="[
                            ['label' => 'FECHA DEVOLUCION'],
                            ['label' => 'EQUIPO', 'class' => 'w-25'],
                            ['label' => 'DEVOLVIO', 'class' => 'text-center'],
                            ['label' => 'MOTIVO', 'class' => 'text-center'],
                            ['label' => 'DOCUMENTO/IMAGEN/COMENTARIO', 'class' => 'text-center'],
                            ['label' => 'ESTADO', 'class' => 'text-center'],
                            ['label' => 'ACCIONES', 'class' => 'text-center'],
                        ]" table-id="example">


                            <tr>
                                <td>
                                    <span class="badge bg-info text-white">17/05/2025 09:12:55</span>
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
                                <td>
                                    <span>SI</span>
                                </td>
                                <td>
                                    <span>Lorem ipsum dolor sit amet consectetur adipisicing elit...</span>
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
                                    <button class="btn btn-dark btn-circle action-btn" title="Ver imágenes"
                                        data-bs-toggle="modal" data-bs-target="#modalimg">
                                        <i class="fa-solid fa-images"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">
                                        <i class="fa-solid fa-lightbulb"></i>&nbsp;Observacion
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm action-btn" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm action-btn" title="Eliminar">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>

                        </x-data-table>
                        <x-btn-documento id="modaldocu" title="DOCUMENTO" size="modal-md">
                            <embed src="" type="application/pdf" width="100%" height="500px" />
                        </x-btn-documento>

                        <x-btn-descripcion id="modaldes" title="DESCRIPCION" size="modal-md">
                        </x-btn-descripcion>
                        <x-btn-imagen id="modalimg" title="IMAGEN" size="modal-md">
                        </x-btn-imagen>
                    </div>
                </div>

            </x-card-header>
        </div>
    </div>
    </div>
@endsection

@push('js')
@endpush
