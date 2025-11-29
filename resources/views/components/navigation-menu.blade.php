<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="d-flex justify-content-center">
        <img src="{{ asset('img/inventario.png') }}" alt="Logo" class="img-fluid mt-0" width="25" height="20">
    </div>
    <hr style="border-color: #ffffff; border-width: 2px;">

    <div class="d-flex justify-content-center">
        <a href="{{ route('panel') }}" class="btn btn-primary btn-sm custom-btn nav-link sidebar-link"
            title="PANEL PRINCIPAL" onclick="activateLink(event, this)">
            <i class="fa-solid fa-table"></i>
            <h6 class="sidebar-text">Panel P</h6>
        </a>
    </div>

    @can('Ver-Inventario')
        <div class="d-flex justify-content-center pt-2 position-relative">
            <div class="dropdown">
                <button class="btn btn-primary btn-sm custom-btn nav-link sidebar-link dropdown-toggle" type="button"
                    id="dropdownInventario" data-bs-toggle="dropdown" aria-expanded="false" title="Inventario">
                    <i class="fa-solid fa-computer"></i>
                    <h6 class="sidebar-text">Inventario</h6>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownInventario">
                    @can('Crear-Inventario')
                        <li>
                            <a class="dropdown-item" href="{{ route('inventario.create') }}">
                                <i class="fa-solid fa-plus me-2"></i>Crear
                            </a>
                        </li>
                    @endcan
                    @can('Ver-Inventario')
                        <li>
                            <a class="dropdown-item" href="{{ route('inventario.index') }}">
                                <i class="fa-solid fa-list me-2"></i>Listar
                            </a>
                        </li>
                    @endcan
                    @can('Historial-Inventario')
                        <li>
                            <a class="dropdown-item" href="{{ route('inventario.historial') }}">
                                <i class="fa-solid fa-clock-rotate-left me-2"></i>Historial
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>
    @endcan

    @can('Ver-Asignacion')
        <div class="d-flex justify-content-center pt-2 position-relative">
            <div class="dropdown">
                <button class="btn btn-primary btn-sm custom-btn nav-link sidebar-link dropdown-toggle" type="button"
                    id="dropdownAsignacion" data-bs-toggle="dropdown" aria-expanded="false" title="ASIGNACIÓN">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    <h6 class="sidebar-text">Asignacion</h6>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownAsignacion">
                    @can('Crear-Asignacion')
                        <li>
                            <a class="dropdown-item" href="{{ route('asignacion.create') }}">
                                <i class="fa-solid fa-plus me-2"></i>Crear
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a class="dropdown-item" href="{{ route('asignacion.index') }}">
                            <i class="fa-solid fa-list me-2"></i>Ver Asignación
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    @endcan

    @can('Ver-Devolucion')
        <div class="d-flex justify-content-center pt-2 position-relative">
            <div class="dropdown">
                <button class="btn btn-primary btn-sm custom-btn nav-link sidebar-link dropdown-toggle" type="button"
                    id="dropdownDevolucion" data-bs-toggle="dropdown" aria-expanded="false" title="DEVOLUCIÓN">
                    <i class="fa-solid fa-repeat"></i>
                    <h6 class="sidebar-text">Devolución</h6>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownDevolucion">
                    @can('Crear-Devolucion')
                        <li>
                            <a class="dropdown-item" href="{{ route('devolucion.create') }}">
                                <i class="fa-solid fa-plus me-2"></i>Crear
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a class="dropdown-item" href="{{ route('devolucion.index') }}">
                            <i class="fa-solid fa-list me-2"></i>Ver Devolución
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    @endcan

    @can('Ver-Catalogo')
        <div class="d-flex justify-content-center pt-2">
            <a href="{{ route('setting.index') }}" class="btn btn-primary btn-sm custom-btn nav-link sidebar-link"
                title="CONFIGURACIÓN" onclick="activateLink(event, this)">
                <i class="fa-solid fa-gear"></i>
                <h6 class="sidebar-text">Setting</h6>
            </a>
        </div>
    @endcan
</div>
