<div class="content" id="content">
    <nav class="navbar border-bottom border-body bg-light">
        <div class="container-fluid">
            <i class="fas fa-bars" id="sidebarCollapse"></i>
            <img src="{{ asset('img/LOGO.png') }}" alt="Logo" class="img-fluid" width="85" height="45">
            <div class="btn-group dropstart">
                <button type="button" class="btn btn-primary rounded-circle" data-bs-toggle="dropdown"
                    aria-expanded="false"
                    style="width: 45px; height: 45px; font-size: 20px; text-align: center; display: flex; justify-content: center; align-items: center;">
                    @php
                        $nombreCompleto = auth()->user()->Name;
                        $iniciales = '';
                        $nombres = explode(' ', $nombreCompleto);
                        foreach ($nombres as $i => $nombre) {
                            if ($i === 0 || $i === 2) {
                                $iniciales .= substr($nombre, 0, 1);
                            }
                        }
                        echo strtoupper($iniciales);
                    @endphp
                </button>


                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item active"><i
                                class="fa-solid fa-id-card-clip"></i>&nbsp;{{ auth()->user()->Email }}<br><i
                                class="fa-solid fa-sitemap"></i>&nbsp;{{ auth()->user()->Name }}</a>
                    </li>
                    <li><a class="dropdown-item" href="">Mi cuenta</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}" title="Cerrar sesion">Cerrar sesion</a>
                    </li>
                </ul>
            </div>


        </div>
    </nav>
</div>
