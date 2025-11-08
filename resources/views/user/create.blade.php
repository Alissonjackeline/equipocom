@extends('template')
@section('title', 'Agregar Usuario')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header 
                title="AGREGAR USUARIO" 
                icon="fa-solid fa-circle-plus me-1"
                :buttons="[
                    [
                        'text' => 'Usuarios',
                        'icon' => 'fa-solid fa-users me-1',
                        'route' => route('user.index'),
                        'variant' => 'persona'
                    ]
                ]">
                  <form action="" method="" class="row">
                     <div class="col-md-4 mb-3">
                         <label for="document" class="form-label fw-semibold">
                             DNI:<span class="text-danger">*</span>
                         </label>
                         <input type="text" name="document" id="document" class="form-control" placeholder="Ingrese dni" required>
                     </div>
                     <div class="col-md-4 mb-3">
                         <label for="name" class="form-label fw-semibold">
                             Nombres completos:<span class="text-danger">*</span>
                         </label>
                         <input type="text" name="name" id="name" class="form-control" placeholder="Ingrese nombres completos" required>
                     </div>

                     <div class="col-md-4 mb-3">
                         <label for="phone" class="form-label fw-semibold">
                             Telefono:<span class="text-danger">*</span>
                         </label>
                         <input type="text" name="phone" id="phone" class="form-control" placeholder="Ingrese telefono" required>
                     </div>

                     <div class="col-md-4 mb-3">
                         <label for="email" class="form-label fw-semibold">
                             Correo:<span class="text-danger">*</span>
                         </label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Ingrese correo" required>
                     </div>

                      <div class="col-md-4 mb-3">
                         <label for="password" class="form-label fw-semibold">
                             Contraseña:<span class="text-danger">*</span>
                         </label>
                        <input type="password" name="password" id="password" placeholder="Ingresar contraseña" class="form-control" required>
                     </div>

                     <div class="col-md-4 mb-3">
                         <label for="password_confirm" class="form-label fw-semibold">
                             Confirmar Contraseña:<span class="text-danger">*</span>
                         </label>
                        <input type="password" name="password_confirm" id="password_confirm" placeholder="Vuelve a escribir su contraseña" class="form-control" required>
                     </div>
                     <div class="col-md-2 mt-2">
                         <button class="btn btn-primary" type="submit">
                             <i class="fa-solid fa-floppy-disk"></i>&nbsp;Guardar
                         </button>
                     </div>
                 </form>
                
            </x-card-header>
        </div>
    </div>


@endsection

@push('js')
@endpush