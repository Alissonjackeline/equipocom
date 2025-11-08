 @extends('template')
 @section('title', 'Jefes')

 @push('css')
     <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
 @endpush
 @section('content')
     <div class="container-fluid">
         <div class="row pt-2">
             <x-card-header title="JEFES" icon="fa-solid fa-id-card-clip">
                 <form action="" method="">
                     <div class="row g-3">
                         <div class="col-md-2">
                             <label for="document" class="form-label fw-semibold">
                                 DNI:<span class="text-danger">*</span>
                             </label>
                             <input type="text" name="document" id="document" class="form-control"
                                 placeholder="Ingrese DNI" required>
                         </div>

                         <div class="col-md-3">
                             <label for="name" class="form-label fw-semibold">
                                 Nombre:<span class="text-danger">*</span>
                             </label>
                             <input type="text" name="name" id="name" class="form-control"
                                 placeholder="Ingrese nombre" required>
                         </div>

                         <div class="col-md-2">
                             <label for="phone" class="form-label fw-semibold">
                                 Telefono:<span class="text-danger">*</span>
                             </label>
                             <input type="text" name="phone" id="phone" class="form-control"
                                 placeholder="Ingrese telefono" required>
                         </div>

                         <div class="col-md-3">
                             <label class="form-label fw-semibold" for="area_id">
                                 Area:
                                 <span class="text-danger">*</span>
                             </label>
                             <select class="form-select" id="area_id" name="area_id" required>
                                 <option value="" selected disabled>Seleccionar area</option>

                             </select>
                         </div>
                         <div class="col-md-2 d-flex align-items-end">
                             <button class="btn btn-primary" type="submit">
                                 <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                             </button>
                         </div>
                     </div>
                 </form>
             </x-card-header>
         </div>
         <div class="row pt-3">
             <div class="col-lg-12">
                 <x-data-table :columns="[
                     ['label' => 'DOCUMENTO'],
                     ['label' => 'NAME'],
                     ['label' => 'CARGO', 'class' => 'text-center'],
                     ['label' => 'TELEFONO', 'class' => 'text-center'],
                     ['label' => 'ESTADO', 'class' => 'text-center'],
                     ['label' => 'ACCIONES', 'class' => 'text-center'],
                 ]" table-id="example">
                     <tr>
                         <td>
                             <div class="info-label">74568533</div>
                         </td>
                         <td>
                             <div class="info-label">NOMBRE DEL JEFE DE AREA</div>
                         </td>
                         <td>
                             <div class="info-label">JEFE DEL AREA DE .....</div>
                         </td>
                         <td>
                             <div class="info-label">999999999</div>
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
             </div>
             <!-- Modal para desactivar -->
                 <x-modal-status id="modal-desactivar" message="¿Seguro que quieres desactivar el jefe?" action="#"
                     confirmText="Desactivar" confirmClass="btn-danger" />

                 <!-- Modal para activar -->
                 <x-modal-status id="modal-activar" message="¿Seguro que quieres activar el jefe?" action="#"
                     confirmText="Activar" confirmClass="btn-success" />

             <x-modal-base id="modalEditar" title="Editar Jefe">
                 <form action="" method="">
                     <div class="row g-3">
                         <div class="col-md-12 pt-2">
                             <label for="document" class="form-label fw-semibold">
                                 DNI:<span class="text-danger">*</span>
                             </label>
                             <input type="text" name="document" id="document" class="form-control"
                                 placeholder="Ingrese DNI" required>
                         </div>

                         <div class="col-md-12 pt-2">
                             <label for="name" class="form-label fw-semibold">
                                 Nombre:<span class="text-danger">*</span>
                             </label>
                             <input type="text" name="name" id="name" class="form-control"
                                 placeholder="Ingrese nombre" required>
                         </div>

                         <div class="col-md-12 pt-2">
                             <label for="phone" class="form-label fw-semibold">
                                 Telefono:<span class="text-danger">*</span>
                             </label>
                             <input type="text" name="phone" id="phone" class="form-control"
                                 placeholder="Ingrese telefono" required>
                         </div>

                         <div class="col-md-12 pt-2">
                             <label class="form-label fw-semibold" for="area_id">
                                 Area:
                                 <span class="text-danger">*</span>
                             </label>
                             <select class="form-select" id="area_id" name="area_id" required>
                                 <option value="" selected disabled>Seleccionar area</option>

                             </select>
                         </div>
                     </div>
                 </form>
             </x-modal-base>
         </div>
     </div>
     </div>


 @endsection

 @push('js')
 @endpush
