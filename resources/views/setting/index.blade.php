 @extends('template')
 @section('title', ' Setting')

 @push('css')
 @endpush

 @section('content')


     <div class="container-fluid">
        @can('Ver-Catalogo')
         <div class="row pt-4 d-flex justify-content-center align-items-center">
             <h3><i class="fa-solid fa-gear"></i>&nbsp;SETTING</h3>

             @can('Ver-Usuario')
                 <div class="col-6 col-md-3 pt-3">
                     <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                         <a href="{{ route('user.index') }}" class="card-link">
                             <img src="{{ asset('img/usuarios.png') }}" alt="usuarios" width="100px">
                         </a>
                         <div class="card-body">
                             <h6 class="card-title">USUARIOS</h6>
                         </div>
                     </div>
                 </div>
             @endcan
             @can('Ver-Rol')
                 <div class="col-6 col-md-3 pt-3">
                     <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                         <a href="{{ route('roles.index') }}" class="card-link">
                             <img src="{{ asset('img/roles.png') }}" alt="roles" width="100px">
                         </a>
                         <div class="card-body">
                             <h6 class="card-title">ROLES</h6>
                         </div>
                     </div>
                 </div>
             @endcan
             @can('Editar-Empresa')
                 <div class="col-6 col-md-3 pt-3">
                     <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                         <a href="{{ route('entities.index') }}" class="card-link">
                             <img src="{{ asset('img/empresa.png') }}" class="mx-auto" alt="sedes" width="90px">
                         </a>
                         <div class="card-body">
                             <h6 class="card-title">EMPRESA</h6>
                         </div>
                     </div>
                 </div>
             @endcan
             @can('Ver-Sedes')
                 <div class="col-6 col-md-3 pt-3">
                     <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                         <a href="{{ route(name: 'sede.index') }}" class="card-link">
                             <img src="{{ asset('img/oficina.png') }}" class="mx-auto" alt="sedes" width="90px">
                         </a>
                         <div class="card-body">
                             <h6 class="card-title">SEDES</h6>
                         </div>
                     </div>
                 </div>
             @endcan
             @can('Ver-Areas')
                 <div class="col-6 col-md-3 pt-3">
                     <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                         <a href="{{ route('area.index') }}" class="card-link">
                             <img src="{{ asset('img/areas.png') }}" class="mx-auto" alt="areas" width="100px">
                         </a>
                         <div class="card-body">
                             <h6 class="card-title">AREAS</h6>
                         </div>
                     </div>
                 </div>
             @endcan
             @can('Ver-Tipo-Equipo')
                 <div class="col-6 col-md-3 pt-3">
                     <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                         <a href="{{ route('tipoequipo.index') }}" class="card-link">
                             <img src="{{ asset('img/ordenador-personal.png') }}" class="mx-auto" alt="tipo de equipos"
                                 width="100px">
                         </a>
                         <div class="card-body">
                             <h6 class="card-title">TIPOS DE EQUIPOS</h6>
                         </div>
                     </div>
                 </div>
             @endcan
             @can('Ver-Jefe')
                 <div class="col-6 col-md-3 pt-3">
                     <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                         <a href="{{ route('jefes.index') }}" class="card-link">
                             <img src="{{ asset('img/lider.png') }}" class="mx-auto" alt="jefes de area" width="100px">
                         </a>
                         <div class="card-body">
                             <h6 class="card-title">JEFES DE AREA</h6>
                         </div>
                     </div>
                 </div>
             @endcan
             @can('Ver-Proveedor')
                 <div class="col-6 col-md-3 pt-3">
                     <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                         <a href="{{ route('proveedor.index') }}" class="card-link">
                             <img src="{{ asset('img/proveedores.png') }}" class="mx-auto" alt="proveedores" width="100px">
                         </a>
                         <div class="card-body">
                             <h6 class="card-title">PROVEEDORES</h6>
                         </div>
                     </div>
                 </div>
             @endcan
         </div>
         @endcan
     </div>


 @endsection

 @push('js')
 @endpush
