@extends('template')
@section('title', 'Empresa')

@push('css')
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row pt-3">
            <x-card-header 
                title="DATOS EMPRESA" 
                icon="fa-solid fa-pen-to-square">
                
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-4 p-2">
                            <label class="form-label fw-semibold" for="razon">
                                Razon social:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="razon" name="razon"
                                placeholder="Ingrese razon social" required>
                        </div>
                        <div class="col-md-4 p-2">
                            <label class="form-label fw-semibold" for="ruc">
                                Ruc:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="ruc" name="ruc"
                                placeholder="Ingrese ruc" required>
                        </div>
                        <div class="col-md-4 p-2">
                            <label class="form-label fw-semibold" for="representative">
                                Representante:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="representative" name="representative"
                                placeholder="Ingrese representante" required>
                        </div>
                        <div class="col-md-4 p-2">
                            <label class="form-label fw-semibold" for="address">
                                Direccion:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Ingrese direccion" required>
                        </div>
                        <div class="col-md-4 p-2">
                            <label class="form-label fw-semibold" for="phone">
                                Telefono:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="phone" name="phone"
                                placeholder="Ingrese telefono" required>
                        </div>
                        <div class="col-md-4 p-2">
                            <label class="form-label fw-semibold" for="correo">
                                Correo:
                                <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese correo"
                                required>
                        </div>
                        <div class="col-md-4 p-2">
                            <label class="form-label fw-semibold" for="image">
                                Imagen:
                            </label>
                            <input class="form-control" type="file" id="image" name="image">
                        </div>
                        
                    </div>
                    <div class="d-flex justify-content-end pt-3">
                        <button class="btn btn-secondary mx-2" type="reset">CANCELAR
                        </button>
                        <button class="btn btn-primary mx-2" type="submit"><i class="fa-solid fa-floppy-disk"></i>
                            GUARDAR
                        </button>
                    </div>
                </form>
                
            </x-card-header>
        </div>
    </div>


@endsection

@push('js')
@endpush