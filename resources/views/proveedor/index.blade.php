 @extends('template')
 @section('title', 'Proveedor')

 @push('css')
     <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
 @endpush
 @section('content')
     <div class="container-fluid">
         <div class="row pt-2">
             <x-card-header title="PROVEDORES" icon="fa-solid fa-boxes-packing">
                 <form action="" method="" class="row">
                     <div class="col-md-2">
                         <label for="company_name" class="form-label fw-semibold">
                             Empresa:<span class="text-danger">*</span>
                         </label>
                         <input type="text" name="company_name" id="company_name" class="form-control"
                             placeholder="Ingrese nombre empresa" required>
                     </div>

                     <div class="col-md-3">
                         <label for="ruc" class="form-label fw-semibold">
                             RUC:<span class="text-danger">*</span>
                         </label>
                         <input type="text" name="ruc" id="ruc" class="form-control" placeholder="Ingrese ruc"
                             required>
                     </div>

                     <div class="col-md-2">
                         <label for="phone" class="form-label fw-semibold">
                             Telefono:<span class="text-danger">*</span>
                         </label>
                         <input type="text" name="phone" id="phone" class="form-control"
                             placeholder="Ingrese telefono" required>
                     </div>
                     <div class="col-md-2">
                         <label for="location" class="form-label fw-semibold">
                             Direccion:<span class="text-danger">*</span>
                         </label>
                         <input type="text" name="location" id="location" class="form-control"
                             placeholder="Ingrese direccion" required>
                     </div>

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
                     ['label' => 'NOMBRE DE EMPRESA'],
                     ['label' => 'RUC'],
                     ['label' => 'TELEFONO', 'class' => 'text-center'],
                     ['label' => 'DIRECCION', 'class' => 'text-center'],
                     ['label' => 'ESTADO', 'class' => 'text-center'],
                     ['label' => 'ACCIONES', 'class' => 'text-center'],
                 ]" table-id="example">
                     <tr>
                         <td class="text-center">
                             <div class="info-label">NOMBRE DE LA EMPRESA</div>
                         </td>
                         <td class="text-center">
                             <div class="info-label">20876497234</div>
                         </td>
                         <td class="text-center">
                             <div class="info-label">9999999</div>
                         </td>
                         <td class="text-center">
                             <div class="info-label">DIRECCION DE EMPRESA</div>
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
                 <x-modal-status id="modal-desactivar" message="¿Seguro que quieres desactivar el proveedor?" action="#"
                     confirmText="Desactivar" confirmClass="btn-danger" />

                 <!-- Modal para activar -->
                 <x-modal-status id="modal-activar" message="¿Seguro que quieres activar el proveedor?" action="#"
                     confirmText="Activar" confirmClass="btn-success" />
                 <x-modal-base id="modalEditar" title="Editar Proveedor">
                     <form action="" method="">
                         <div class="col-md-12 pt-2">
                             <label for="company_name" class="form-label fw-semibold">
                                 Empresa:<span class="text-danger">*</span>
                             </label>
                             <input type="text" name="company_name" id="company_name" class="form-control"
                                 placeholder="Ingrese nombre empresa" required>
                         </div>

                         <div class="col-md-12 pt-2">
                             <label for="ruc" class="form-label fw-semibold">
                                 RUC:<span class="text-danger">*</span>
                             </label>
                             <input type="text" name="ruc" id="ruc" class="form-control"
                                 placeholder="Ingrese ruc" required>
                         </div>

                         <div class="col-md-12 pt-2">
                             <label for="phone" class="form-label fw-semibold">
                                 Telefono:<span class="text-danger">*</span>
                             </label>
                             <input type="text" name="phone" id="phone" class="form-control"
                                 placeholder="Ingrese telefono" required>
                         </div>
                         <div class="col-md-12 pt-2">
                             <label for="location" class="form-label fw-semibold">
                                 Direccion:<span class="text-danger">*</span>
                             </label>
                             <input type="text" name="location" id="location" class="form-control"
                                 placeholder="Ingrese direccion" required>
                         </div>

                     </form>
                 </x-modal-base>


             </div>
         </div>
     </div>
     </div>


 @endsection

 @push('js')
 @endpush
