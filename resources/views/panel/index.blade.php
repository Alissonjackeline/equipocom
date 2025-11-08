 @extends('template')
 @section('title','Panel')

 @section('content')

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