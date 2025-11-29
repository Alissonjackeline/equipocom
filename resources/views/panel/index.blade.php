 @extends('template')
 @section('title', 'Panel')

 @section('content')
     @if (session('success'))
         <script>
             document.addEventListener('DOMContentLoaded', function() {
                 Swal.fire({
                     title: '<h2 style="color: #4CAF50; font-weight: bold;">¡Bienvenido, {{ session('success') }}!</h2>',
                     html: `<p style="font-size: 1.1em; color: #333;">Sistema de Asignacion de equipos</p>`,
                     icon: "success",
                     showConfirmButton: true,
                     timer: 5000,
                     timerProgressBar: true,
                     background: 'linear-gradient(to right, #e0f7fa, #ffffff)',
                     padding: '1.5em',
                 });
             });
         </script>
     @endif
     <div class="container-fluid">
         <div class="row pt-1">
             <div class="col-12 col-md-12">
                 <div class="row">
                     <x-card icon="fa-solid fa-users" title="TOTAL DE USUARIOS" value="" bgColor="bg-primary" />
                     <x-card icon="fa-solid fa-users" title="TOTAL DE USUARIOS" value="" bgColor="bg-primary" />
                     <x-card icon="fa-solid fa-users" title="TOTAL DE USUARIOS" value="" bgColor="bg-primary" />
                     <x-card icon="fa-solid fa-users" title="TOTAL DE USUARIOS" value="" bgColor="bg-primary" />
                     <x-card icon="fa-solid fa-users" title="TOTAL DE USUARIOS" value="" bgColor="bg-primary" />
                     <x-card icon="fa-solid fa-users" title="TOTAL DE USUARIOS" value="" bgColor="bg-primary" />
                     <x-card icon="fa-solid fa-users" title="TOTAL DE USUARIOS" value="" bgColor="bg-primary" />
                     <x-card icon="fa-solid fa-users" title="TOTAL DE USUARIOS" value="" bgColor="bg-primary" />
                 </div>
             </div>

             <div class="col-12 col-md-6 pt-2">
                 <div class="card" id="card1">
                     <h5 class="card-header text-center" id="encabezado">
                         <i class="fa-solid fa-file-circle-plus"></i>&nbsp;Asignaciones recientes
                     </h5>

                     <div class="card-body p-3" id="card3">
                         contenido
                     </div>

                 </div>
             </div>
             <div class="col-12 col-md-6 pt-2">
                 <div class="card" id="card1">
                     <h5 class="card-header text-center" id="encabezado">
                         <i class="fa-solid fa-repeat"></i>&nbsp;Devoluciones recientes
                     </h5>

                     <div class="card-body p-3" id="card3">
                         contenido
                     </div>

                 </div>
             </div>


         </div>
     </div>
     </div>

 @endsection

 @push('js')
 @endpush
