@extends('template')
@section('title', 'Perfil')

@push('css')
<link href="{{ asset('Css/perfil.css') }}" rel="stylesheet" />
@endpush

@section('content')
@include('layouts.partials.alert')
<div class="container-fluid">
    <div class="row pt-2">
        <div class="col-lg-12">
            <div class="card" id="card">
                <h5 class="card-header" id="encabezado">CONFIGURAR PERFIL</h5>
                <div class="card__img"></div>
                <div class="card__avatar">
                    <h1>
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
                    </h1>
                </div>
            </div>

            <div class="card" id="card">
                <div class="card-body pt-6">
                    <form action="{{ route('profile.update', ['profile' => $user->idUser]) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        
                        <div class="form-group row">
                            <div class="col-md-3 pt-2">
                                <label for="Document">DNI:<span class="text-danger">&nbsp;*</span></label>
                                <div class="input-group">
                                    <input type="text" name="Document" id="Document" class="form-control" 
                                           value="{{ old('Document', $user->Document) }}" maxlength="8">
                                </div>
                                @error('Document')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-5 pt-2">
                                <label for="Name">Nombres Completos:<span class="text-danger">&nbsp;*</span></label>
                                <div class="input-group">
                                    <input type="text" name="Name" id="Name" class="form-control" 
                                           value="{{ old('Name', $user->Name) }}">
                                </div>
                                @error('Name')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 pt-2">
                                <label for="Email">Email:<span class="text-danger">&nbsp;*</span></label>
                                <div class="input-group">
                                    <input type="email" name="Email" id="Email" class="form-control" 
                                           value="{{ old('Email', $user->Email) }}" autocomplete="email">
                                </div>
                                @error('Email')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3 pt-2">
                                <label for="Phone">Teléfono:<span class="text-danger">&nbsp;*</span></label>
                                <div class="input-group">
                                    <input type="text" name="Phone" id="Phone" class="form-control" 
                                           value="{{ old('Phone', $user->Phone) }}" maxlength="9">
                                </div>
                                @error('Phone')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3 pt-2">
                                <label for="Password">Contraseña:</label>
                                <div class="input-group">
                                    <input type="password" name="Password" id="Password" class="form-control" 
                                           placeholder="Dejar en blanco para mantener la actual">
                                </div>
                                @error('Password')
                                    <small class="text-danger">{{ '*' . $message }}</small>
                                @enderror
                                <small class="text-muted">Solo completar si desea cambiar la contraseña</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center pt-3">
                            <button class="btn btn-primary btn-sm mx-2" type="submit">
                                <i class="fa-solid fa-floppy-disk me-1"></i>Guardar Cambios
                            </button>
                            <a href="{{ route('panel') }}" class="btn btn-secondary btn-sm">
                                <i class="fa-solid fa-arrow-left me-1"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush