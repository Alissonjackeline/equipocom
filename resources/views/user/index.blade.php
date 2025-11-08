@extends('template')
@section('title', 'Usuarios')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header title="LISTA DE USUARIO" icon="fa-solid fa-users" :buttons="[
                [
                    'text' => 'Agregar',
                    'icon' => 'fa-solid fa-circle-plus me-1',
                    'route' => route('user.create'),
                    'variant' => 'persona',
                ],
            ]">


                <x-data-table :columns="[
                    ['label' => 'NOMBRES COMPLETOS'],
                    ['label' => 'ROL'],
                    ['label' => 'TELEFONO', 'class' => 'text-center'],
                    ['label' => 'EMAIL', 'class' => 'text-center'],
                    ['label' => 'ESTADO', 'class' => 'text-center'],
                    ['label' => 'ACCIONES', 'class' => 'text-center'],
                ]" table-id="example">

                    <tr>
                        <td>
                            <div class="mb-1">
                                <span class="info-label">HERNAN POMA</span>
                                <span class="info-value">77777777</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-purple text-white">
                                <i class="fa-solid fa-user me-1"></i>Rol
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="info-label">65564645</div>
                        </td>
                        <td class="text-center">
                            <div class="info-label">areavigilancia@muni.gob.pe</div>
                        </td>
                        <td class="custonfon text-center">
                             <span class="badge text-bg-success">Activo</span>
                             <span class="badge text-bg-danger">Inactivo</span>
                         </td>

                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar"
                                title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modal-desactivar" title="Desactivar">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modal-activar" title="Activar">
                                <i class="fa-solid fa-circle-check"></i>
                            </button>
                        </td>
                    </tr>

                </x-data-table>

                <!-- Modal para desactivar -->
                <x-modal-status id="modal-desactivar" message="¿Seguro que quieres desactivar el usuario?" action="#"
                    confirmText="Desactivar" confirmClass="btn-danger" />

                <!-- Modal para activar -->
                <x-modal-status id="modal-activar" message="¿Seguro que quieres activar el usuario?" action="#"
                    confirmText="Activar" confirmClass="btn-success" />
                <x-modal-base id="modalEditar" title="Editar Usuario">
                    <form action="" method="" class="row">
                        <div class="col-md-12 pt-2">
                            <label for="document" class="form-label fw-semibold">
                                DNI:<span class="text-danger">*</span>
                            </label>
                            <input type="text" name="document" id="document" class="form-control"
                                placeholder="Ingrese dni" required>
                        </div>
                        <div class="col-md-12 pt-2">
                            <label for="name" class="form-label fw-semibold">
                                Nombres completos:<span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Ingrese nombres completos" required>
                        </div>

                        <div class="col-md-12 pt-2">
                            <label for="phone" class="form-label fw-semibold">
                                Telefono:<span class="text-danger">*</span>
                            </label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                placeholder="Ingrese telefono" required>
                        </div>

                        <div class="col-md-12 pt-2">
                            <label for="email" class="form-label fw-semibold">
                                Correo:<span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Ingrese correo" required>
                        </div>

                        <div class="col-md-12 pt-2">
                            <label for="password" class="form-label fw-semibold">
                                Contraseña:<span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password" id="password" placeholder="Ingresar contraseña"
                                class="form-control" required>
                        </div>
                    </form>
                </x-modal-base>
        </div>
        </x-card-header>
    </div>
@endsection

@push('js')
@endpush
