@extends('template')
@section('title', 'Empresa')

@section('content')
@include('layouts.partials.alert')
<div class="container-fluid">
    <div class="row pt-3">
        <x-card-header title="DATOS EMPRESA" icon="fa-solid fa-pen-to-square">

            <form action="{{ route('entities.update', $entities->idEntity) }}" 
                  method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 p-2">
                        <label class="form-label fw-semibold">Razon social:<span
                                class="text-danger">*</span></label>
                        <input type="text" name="Razon" class="form-control"
                               value="{{ old('Razon', $entities->Razon) }}">
                    </div>

                    <div class="col-md-4 p-2">
                        <label class="form-label fw-semibold">Ruc:<span
                                class="text-danger">*</span></label>
                        <input type="number" name="Ruc" class="form-control"
                               value="{{ old('Ruc', $entities->Ruc) }}">
                    </div>

                    <div class="col-md-4 p-2">
                        <label class="form-label fw-semibold">Representante:<span
                                class="text-danger">*</span></label>
                        <input type="text" name="Representative" class="form-control"
                               value="{{ old('Representative', $entities->Representative) }}">
                    </div>

                    <div class="col-md-4 p-2">
                        <label class="form-label fw-semibold">Dirección:<span
                                class="text-danger">*</span></label>
                        <input type="text" name="Address" class="form-control"
                               value="{{ old('Address', $entities->Address) }}">
                    </div>

                    <div class="col-md-4 p-2">
                        <label class="form-label fw-semibold">Teléfono:<span
                                class="text-danger">*</span></label>
                        <input type="number" name="Phone" class="form-control"
                               value="{{ old('Phone', $entities->Phone) }}">
                    </div>

                    <div class="col-md-4 p-2">
                        <label class="form-label fw-semibold">Correo:<span
                                class="text-danger">*</span></label>
                        <input type="email" name="Correo" class="form-control"
                               value="{{ old('Correo', $entities->Correo) }}">
                    </div>

                    <div class="col-md-4 p-2">
                        <label class="form-label fw-semibold">Imagen:</label>
                        <input class="form-control" type="file" name="Image">
                        @if ($entities->Image)
                            <small class="text-success">Imagen actual: {{ $entities->Image }}</small>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end pt-3">
                    <button class="btn btn-secondary mx-2" type="reset">CANCELAR</button>
                    <button class="btn btn-primary mx-2" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i> GUARDAR
                    </button>
                </div>

            </form>

        </x-card-header>
    </div>
</div>
@endsection
