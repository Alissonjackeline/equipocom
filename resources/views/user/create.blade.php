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
                ],
            ]">

                <form action="{{ route('user.store') }}" method="POST" class="row">
                    @csrf

                    <div class="col-md-4 mb-3">
                        <label for="document" class="form-label fw-semibold">
                            DNI:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="document" id="document"
                            class="form-control @error('document') is-invalid @enderror" placeholder="Ingrese dni"
                            value="{{ old('document') }}" required maxlength="8">
                        @error('document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label fw-semibold">
                            Nombres completos:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Ingrese nombres completos"
                            value="{{ old('name') }}" required maxlength="70">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="phone" class="form-label fw-semibold">
                            Teléfono:<span class="text-danger">*</span>
                        </label>
                        <input type="text" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror" placeholder="Ingrese teléfono"
                            value="{{ old('phone') }}" required maxlength="20">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="email" class="form-label fw-semibold">
                            Correo:<span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Ingrese correo"
                            value="{{ old('email') }}" required maxlength="50">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="password" class="form-label fw-semibold">
                            Contraseña:<span class="text-danger">*</span>
                        </label>
                        <input type="password" name="password" id="password" placeholder="Ingresar contraseña"
                            class="form-control @error('password') is-invalid @enderror" required minlength="8">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">
                            Confirmar Contraseña:<span class="text-danger">*</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Vuelve a escribir su contraseña" class="form-control" required minlength="8">
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

            </x-card-header>
        </div>
    </div>
@endsection

@push('js')
@endpush
