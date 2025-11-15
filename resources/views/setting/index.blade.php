 @extends('template')
 @section('title',' Setting')

 @push('css')

 @endpush

 @section('content')


 <div class="container-fluid">
     <div class="row pt-4 d-flex justify-content-center align-items-center">
         <h3><i class="fa-solid fa-gear"></i>&nbsp;SETTING</h3>
      
         <div class="col-6 col-md-3 pt-3">
             <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                 <a href="{{ route('user.index')}}" class="card-link">
                     <img src="{{ asset('img/usuarios.png') }}" alt="usuarios" width="100px">
                 </a>
                 <div class="card-body">
                     <h6 class="card-title">USUARIOS</h6>
                 </div>
             </div>
         </div>

         <div class="col-6 col-md-3 pt-3">
             <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                 <a href="{{ route('rol.index')}}" class="card-link">
                     <img src="{{ asset('img/roles.png') }}" alt="roles" width="100px">
                 </a>
                 <div class="card-body">
                     <h6 class="card-title">ROLES</h6>
                 </div>
             </div>
         </div>

         <div class="col-6 col-md-3 pt-3">
             <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                 <a href="{{ route('entities.index')}}" class="card-link">
                     <img src="{{ asset('img/empresa.png') }}" class="mx-auto" alt="sedes" width="90px">
                 </a>
                 <div class="card-body">
                     <h6 class="card-title">EMPRESA</h6>
                 </div>
             </div>
         </div>

         <div class="col-6 col-md-3 pt-3">
             <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                 <a href="{{ route(name: 'sede.index')}}" class="card-link">
                     <img src="{{ asset('img/oficina.png') }}" class="mx-auto" alt="sedes" width="90px">
                 </a>
                 <div class="card-body">
                     <h6 class="card-title">SEDES</h6>
                 </div>
             </div>
         </div>

         <div class="col-6 col-md-3 pt-3">
             <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                 <a href="{{ route('area.index')}}" class="card-link">
                     <img src="{{ asset('img/areas.png') }}" class="mx-auto" alt="areas" width="100px">
                 </a>
                 <div class="card-body">
                     <h6 class="card-title">AREAS</h6>
                 </div>
             </div>
         </div>

         <div class="col-6 col-md-3 pt-3">
             <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                 <a href="{{ route('tipoequipo.index')}}" class="card-link">
                     <img src="{{ asset('img/ordenador-personal.png') }}" class="mx-auto" alt="tipo de equipos"
                         width="100px">
                 </a>
                 <div class="card-body">
                     <h6 class="card-title">TIPOS DE EQUIPOS</h6>
                 </div>
             </div>
         </div>

         <div class="col-6 col-md-3 pt-3">
             <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                 <a href="{{ route('jefes.index')}}" class="card-link">
                     <img src="{{ asset('img/lider.png') }}" class="mx-auto" alt="jefes de area" width="100px">
                 </a>
                 <div class="card-body">
                     <h6 class="card-title">JEFES DE AREA</h6>
                 </div>
             </div>
         </div>

         <div class="col-6 col-md-3 pt-3">
             <div class="card text-center d-flex align-items-center pt-3 custom-card" style="border-radius: 30px">
                 <a href="{{ route('proveedor.index')}}" class="card-link">
                     <img src="{{ asset('img/proveedores.png') }}" class="mx-auto" alt="proveedores" width="100px">
                 </a>
                 <div class="card-body">
                     <h6 class="card-title">PROVEEDORES</h6>
                 </div>
             </div>
         </div>

     </div>
 </div>


 @endsection

 @push('js')
 @endpush