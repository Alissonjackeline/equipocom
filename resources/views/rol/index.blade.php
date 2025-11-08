@extends('template')
@section('title', 'Roles')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header title="LISTA DE ROLES" icon="fa-solid fa-address-card" :buttons="[
                [
                    'text' => 'Agregar',
                    'icon' => 'fa-solid fa-circle-plus me-1',
                    'route' => route('rol.create'),
                    'variant' => 'persona',
                ],
            ]">


                <x-data-table :columns="[
                    ['label' => 'ROL'],
                    ['label' => 'PERMISOS'],
                    ['label' => 'ACCIONES', 'class' => 'text-center'],
                ]" table-id="example">
                    <tr>
                        <td>
                            <div class="mb-1">
                                <span class="info-value">Administrador</span>
                            </div>
                        </td>
                        <td><span class="badge text-bg-primary">Permiso1</span>
                        <span class="badge text-bg-primary">Permiso2</span>
                        <span class="badge text-bg-primary">Permiso3</span>
                        <span class="badge text-bg-primary">Permiso4</span>
                        <span class="badge text-bg-primary">Permiso5</span></td>
                        
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
        </div>
        </x-card-header>
    </div>
@endsection

@push('js')
@endpush
