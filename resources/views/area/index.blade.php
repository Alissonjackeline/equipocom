 @extends('template')
 @section('title', 'Area')

 @push('css')
     <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
 @endpush
 @section('content')
     <div class="container-fluid">
         <div class="row pt-2">
             <x-card-header title="AREAS" icon="fa-solid fa-sitemap">
                 <form action="" method="POST" class="row">
                     <!-- Nombre del área -->
                     <div class="col-md-4">
                         <label for="name" class="form-label fw-semibold">Nombre del Area:<span
                                 class="text-danger">*</span></label>
                         <input type="text" name="name" id="name" class="form-control" value=""
                             placeholder="Ingresar Nombre" required>
                     </div>
                     <div class="col-md-4">
                         <label for="headquarters_id" class="form-label fw-semibold">Sede:<span
                                 class="text-danger">*</span></label>
                         <select name="headquarters_id" id="headquarters_id" class="form-select" required>
                             <option value="" disabled selected>Seleccionar Sede</option>
                             <option value="" </option>
                         </select>
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
                     ['label' => 'NOMBRE DE AREA'],
                     ['label' => 'SEDE'],
                     ['label' => 'ESTADO', 'class' => 'text-center'],
                     ['label' => 'ACCIONES', 'class' => 'text-center'],
                 ]" table-id="example">
                     <tr>
                         <td>
                             <div class="info-label">NOMBRE DE AREA</div>
                         </td>
                         <td>
                             <div class="info-label">NOMBRE DE SEDE</div>
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
                 <x-modal-status id="modal-desactivar" message="¿Seguro que quieres desactivar el area?" action="#"
                     confirmText="Desactivar" confirmClass="btn-danger" />

                 <!-- Modal para activar -->
                 <x-modal-status id="modal-activar" message="¿Seguro que quieres activar el area?" action="#"
                     confirmText="Activar" confirmClass="btn-success" />

                 <x-modal-base id="modalEditar" title="Editar Area">
                   <form action="" method="POST">
                     <!-- Nombre del área -->
                     <div class="col-md-12 pt-2">
                         <label for="name" class="form-label fw-semibold">Nombre del Area:<span
                                 class="text-danger">*</span></label>
                         <input type="text" name="name" id="name" class="form-control" value=""
                             placeholder="Ingresar Nombre" required>
                     </div>
                     <div class="col-md-12 pt-2">
                         <label for="headquarters_id" class="form-label fw-semibold">Sede:<span
                                 class="text-danger">*</span></label>
                         <select name="headquarters_id" id="headquarters_id" class="form-select" required>
                             <option value="" disabled selected>Seleccionar Sede</option>
                             <option value="" </option>
                         </select>
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
