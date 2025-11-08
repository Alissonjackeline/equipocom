<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="d-flex justify-content-center">
        <img src="{{ asset('img/inventario.png') }}" alt="Logo" class="img-fluid mt-0" width="25" height="20">
    </div>
    <hr style="border-color: #ffffff; border-width: 2px;">
    
    <div class="d-flex justify-content-center">
        <a href="{{ route('panel')}}" class="btn btn-primary btn-sm custom-btn nav-link sidebar-link" title="PANEL PRINCIPAL" onclick="activateLink(event, this)">
            <i class="fa-solid fa-table"></i>
            <h6 class="sidebar-text">Panel P</h6>
        </a>
    </div>
    
    <div class="d-flex justify-content-center pt-2">
        <a href="{{ route('inventario.index')}}" class="btn btn-primary btn-sm custom-btn nav-link sidebar-link" title="Inventario" onclick="activateLink(event, this)">
            <i class="fa-solid fa-computer"></i>
            <h6 class="sidebar-text">Inventario</h6>
        </a>
    </div>
    
    <div class="d-flex justify-content-center pt-2">
        <a href="{{ route('asignacion.index')}}" class="btn btn-primary btn-sm custom-btn nav-link sidebar-link" title="NUEVA ASIGNACIÓN" onclick="activateLink(event, this)">
            <i class="fa-solid fa-file-circle-plus"></i>
            <h6 class="sidebar-text">Asignacion</h6>
        </a>
    </div>
    
    <div class="d-flex justify-content-center pt-2">
        <a href="{{ route('devolucion.index')}}" class="btn btn-primary btn-sm custom-btn nav-link sidebar-link" title="DEVOLUCIÓN" onclick="activateLink(event, this)">
            <i class="fa-solid fa-repeat"></i>
            <h6 class="sidebar-text">Devolución</h6>
        </a>
    </div>
    
    <div class="d-flex justify-content-center pt-2">
        <a href="{{ route('setting.index')}}" class="btn btn-primary btn-sm custom-btn nav-link sidebar-link" title="CONFIGURACIÓN" onclick="activateLink(event, this)">
            <i class="fa-solid fa-gear"></i>
            <h6 class="sidebar-text">Setting</h6>
        </a>
    </div>
</div>