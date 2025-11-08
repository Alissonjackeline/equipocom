<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de equipos</title>
    <link rel="icon" href="{{ asset('img/inventario.png') }}" type="image/x-icon">
    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/login.css') }}" rel="stylesheet" />

    <script src="{{ asset('js/sweetalert.js') }}"></script>
    
</head>

<body>
    <div id="content" class="container-fluid p-0">
        <div class="row g-0 vh-100">
            <div class="d-none d-md-flex col-md-8 flex-column justify-content-center align-items-center bg-gradient-primary">
                <div class="text-center text-white position-relative" style="z-index: 1;">
                    <img src="{{ asset('img/inventario.png') }}" alt="Sistema" width="280" class="mb-4 icon-float">
                    <h2 class="fw-bold mb-3">SGCAEC</h2>
                </div>
            </div>

            <div class="col-12 col-md-4 d-flex justify-content-center align-items-center" style="background: #f8f9fa;">
                <div style="max-width: 420px; width: 90%;">
                     <form id="login-form" action="{{ route('login.submit') }}" method="post">
                        @csrf
                        <div class="logo-container text-center">
                            <img src="{{ asset('img/LOGO.png') }}" alt="icono" style="width: 200px;">
                        </div>
                        
                        
                        <h6 class="welcome-title text-center">
                            Bienvenido al sistema de gestion para el control de asignacion de equipos de computo 👋
                        </h6>

                        <div class="mb-3">
                            <label class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="correo@ejemplo.com" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Contraseña<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            Iniciar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
</body>
<x-footer></x-footer>
</html>