@extends('template')
@section('title', 'Sedes')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')

    @include('layouts.partials.alert')

    <div class="container-fluid">

        <div class="row pt-2">
            <x-card-header title="SEDES" icon="fa-solid fa-building">

                <form action="{{ route('sede.store') }}" method="POST" class="row">
                    @csrf

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Nombre de sede:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Name" class="form-control" placeholder="Ingresar nombre" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Dirección:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Address" class="form-control" placeholder="Ingresar dirección" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Teléfono:<span class="text-danger">*</span></label>
                        <input type="text" name="Phone" class="form-control" placeholder="Ingresar teléfono">
                    </div>

                    <input type="hidden" name="Entity_id" value="1">

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                        </button>
                    </div>

                </form>

            </x-card-header>
        </div>

        <div class="row pt-3">
            <div class="col-lg-12">

                <x-data-table :columns="[
                    ['label' => 'NOMBRE DE SEDE'],
                    ['label' => 'DIRECCIÓN'],
                    ['label' => 'TELÉFONO', 'class' => 'text-center'],
                    ['label' => 'ESTADO', 'class' => 'text-center'],
                    ['label' => 'ACCIÓN', 'class' => 'text-center'],
                ]" table-id="example">

                    @foreach ($headquarters as $hq)
                        <tr>

                            <td>{{ $hq->Name }}</td>

                            <td>{{ $hq->Address }}</td>

                            <td class="text-center">{{ $hq->Phone }}</td>

                            <td class="text-center">
                                @if ($hq->Status == 1)
                                    <span class="badge text-bg-success">Activo</span>
                                @else
                                    <span class="badge text-bg-danger">Inactivo</span>
                                @endif
                            </td>

                            <td class="text-center">

                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalEditar{{ $hq->idHeadquarters }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn {{ $hq->Status == 1 ? 'btn-danger' : 'btn-success' }} btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#modalEstado{{ $hq->idHeadquarters }}">
                                    <i class="fa-solid {{ $hq->Status == 1 ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                </button>

                            </td>

                        </tr>

                        <x-modal-status id="modalEstado{{ $hq->idHeadquarters }}"
                            message="¿Seguro que deseas {{ $hq->Status == 1 ? 'desactivar' : 'activar' }} esta sede?"
                            action="{{ route('sede.destroy', $hq->idHeadquarters) }}"
                            confirmText="{{ $hq->Status == 1 ? 'Desactivar' : 'Activar' }}"
                            confirmClass="{{ $hq->Status == 1 ? 'btn-danger' : 'btn-success' }}" />

                        <x-modal-base id="modalEditar{{ $hq->idHeadquarters }}" title="Editar Sede" size="modal-lg">
                            <form action="{{ route('sede.update', $hq->idHeadquarters) }}" method="POST" class="row">
                                @csrf
                                @method('PUT')

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">Nombre de sede:<span class="text-danger">*</span></label>
                                    <input type="text" name="Name" class="form-control" value="{{ $hq->Name }}"
                                        required>
                                </div>

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">Dirección:<span class="text-danger">*</span></label>
                                    <input type="text" name="Address" class="form-control" value="{{ $hq->Address }}"
                                        required>
                                </div>

                                <div class="col-md-12 pt-2">
                                    <label class="form-label fw-semibold">Teléfono:<span class="text-danger">*</span></label>
                                    <input type="text" name="Phone" class="form-control" value="{{ $hq->Phone }}">
                                </div>

                                <input type="hidden" name="Entity_id" value="{{ $hq->Entity_id }}">
                        </x-modal-base>

                        </form>
                    @endforeach

                </x-data-table>

            </div>
        </div>

    </div>

@endsection

@push('js')
@endpush
