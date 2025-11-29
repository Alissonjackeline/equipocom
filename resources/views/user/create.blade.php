@extends('template')
@section('title', 'Agregar Usuario')

@push('css')
    <link href="{{ asset('Css/inventario.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.partials.alert')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header title="AGREGAR USUARIO" icon="fa-solid fa-circle-plus me-1" :buttons="[
                [
                    'text' => 'Usuarios',
                    'icon' => 'fa-solid fa-users me-1',
                    'route' => route('user.index'),
                    'variant' => 'persona',
                    'permission' => 'Ver-Usuario', 
                ],
            ]">

                @can('Crear-Usuario')
                <form action="{{ route('user.store') }}" method="POST" class="row">
                    @csrf

                    <div class="col-md-4 mb-3">
                        <label for="Document" class="form-label fw-semibold">
                            DNI:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Document" id="Document"
                            class="form-control @error('Document') is-invalid @enderror" placeholder="Ingrese dni"
                            value="{{ old('Document') }}" required maxlength="8">
                        @error('Document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="Name" class="form-label fw-semibold">
                            Nombres completos:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Name" id="Name"
                            class="form-control @error('Name') is-invalid @enderror" placeholder="Ingrese nombres completos"
                            value="{{ old('Name') }}" required maxlength="70">
                        @error('Name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="Phone" class="form-label fw-semibold">
                            Teléfono:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="Phone" id="Phone"
                            class="form-control @error('Phone') is-invalid @enderror" placeholder="Ingrese teléfono"
                            value="{{ old('Phone') }}" required maxlength="20">
                        @error('Phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="Email" class="form-label fw-semibold">
                            Correo:<span class="text-danger">*</span>
                        </label>
                        <input type="email" name="Email" id="Email"
                            class="form-control @error('Email') is-invalid @enderror" placeholder="Ingrese correo"
                            value="{{ old('Email') }}" required maxlength="50">
                        @error('Email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="role" class="form-label fw-semibold">
                            Rol:<span class="text-danger">*</span>
                        </label>
                        <select name="role" id="role" class="form-control selectpicker show-tick @error('role') is-invalid @enderror"
                            data-size="5" required>
                            <option value="" selected disabled>Seleccionar Rol</option>
                            @foreach($roles as $item)
                                <option value="{{ $item->name }}" @selected(old('role') == $item->name)>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="Password" class="form-label fw-semibold">
                            Contraseña:<span class="text-danger">*</span>
                        </label>
                        <input type="password" name="Password" id="Password" placeholder="Ingresar contraseña"
                            class="form-control @error('Password') is-invalid @enderror" required minlength="8">
                        @error('Password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="Password_confirmation" class="form-label fw-semibold">
                            Confirmar Contraseña:<span class="text-danger">*</span>
                        </label>
                        <input type="password" name="Password_confirmation" id="Password_confirmation"
                            placeholder="Vuelve a escribir su contraseña" class="form-control @error('Password_confirmation') is-invalid @enderror" 
                            required minlength="8">
                        @error('Password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end pt-4">
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-times"></i>&nbsp;Cancelar
                        </a>
                        <button class="btn btn-primary mx-2" type="submit">
                            <i class="fa-solid fa-floppy-disk"></i> GUARDAR
                        </button>
                    </div>
                </form>
                @else
                    <div class="alert alert-warning text-center">
                        <i class="fa-solid fa-triangle-exclamation fa-2x mb-3"></i>
                        <h5>No tienes permisos para crear usuarios</h5>
                        <p class="mb-0">Contacta al administrador si necesitas acceso a esta función.</p>
                    </div>
                @endcan

            </x-card-header>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if ($('.selectpicker').length) {
                $('.selectpicker').selectpicker();
            }

            // Validación de DNI (solo números)
            const dniInput = document.getElementById('Document');
            if (dniInput) {
                dniInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            const phoneInput = document.getElementById('Phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9+-\s]/g, '');
                });
            }

            const password = document.getElementById('Password');
            const confirmPassword = document.getElementById('Password_confirmation');
            
            function validatePassword() {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity("Las contraseñas no coinciden");
                } else {
                    confirmPassword.setCustomValidity("");
                }
            }

            if (password && confirmPassword) {
                password.addEventListener('change', validatePassword);
                confirmPassword.addEventListener('keyup', validatePassword);
            }
        });
    </script>
@endpush