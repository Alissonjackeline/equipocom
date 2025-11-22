@props([
    'equipment',
    'equipmentTypes',
    'suppliers'
])

<div class="modal fade" id="modalEditar{{ $equipment->idEquipment }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" id="encabezado">
                <i class="fa-solid fa-pen-to-square"></i>
                <h5 class="modal-title">Editar Equipo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inventario.update', $equipment->idEquipment) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tipo de equipo:<span class="text-danger">*</span></label>
                            <select class="form-control selectpicker show-tick" data-size="5" data-live-search="true" name="EquipmentType_id" required>
                                <option value="" disabled>Seleccionar tipo</option>
                                @foreach ($equipmentTypes as $type)
                                    <option value="{{ $type->idEquipmentType }}"
                                        {{ $equipment->EquipmentType_id == $type->idEquipmentType ? 'selected' : '' }}>
                                        {{ $type->Name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('EquipmentType_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Código patrimonial:<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="CodigoPatri"
                                value="{{ $equipment->CodigoPatri }}" required>
                            @error('CodigoPatri')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Serie:<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="Series"
                                value="{{ $equipment->Series }}" required>
                            @error('Series')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Modelo:<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="Model"
                                value="{{ $equipment->Model }}" required>
                            @error('Model')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Marca:<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="Brand"
                                value="{{ $equipment->Brand }}" required>
                            @error('Brand')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Precio (S/):<span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="Price"
                                value="{{ $equipment->Price }}" required>
                            @error('Price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estado:<span class="text-danger">*</span></label>
                            <select class="form-control selectpicker show-tick" data-size="5" data-live-search="true" name="status" required>
                                <option value="1" {{ $equipment->status == 1 ? 'selected' : '' }}>Disponible</option>
                                <option value="2" {{ $equipment->status == 2 ? 'selected' : '' }}>Por preparar</option>
                                <option value="3" {{ $equipment->status == 3 ? 'selected' : '' }}>En uso</option>
                                <option value="4" {{ $equipment->status == 4 ? 'selected' : '' }}>Observación</option>
                                <option value="5" {{ $equipment->status == 5 ? 'selected' : '' }}>Reparación Pendiente</option>
                                <option value="6" {{ $equipment->status == 6 ? 'selected' : '' }}>No devuelto</option>
                                <option value="7" {{ $equipment->status == 7 ? 'selected' : '' }}>Perdida-Robo</option>
                                <option value="8" {{ $equipment->status == 8 ? 'selected' : '' }}>De baja</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Proveedor:<span class="text-danger">*</span></label>
                            <select class="form-control selectpicker show-tick" data-size="5" data-live-search="true" name="Supplier_id" required>
                                <option value="" disabled>Seleccionar proveedor</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->idSupplier }}"
                                        {{ $equipment->Supplier_id == $supplier->idSupplier ? 'selected' : '' }}>
                                        {{ $supplier->Company_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('Supplier_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Descripción:<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="Description" rows="3" required>{{ $equipment->Description }}</textarea>
                            @error('Description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Imagen:</label>
                            <input class="form-control" type="file" name="Imagen">
                            @if ($equipment->Imagen)
                                <div class="mt-2">
                                    <small class="text-muted">Imagen actual: {{ basename($equipment->Imagen) }}</small>
                                    <br>
                                    <img src="{{ $equipment->image_url }}" alt="Imagen actual" class="img-thumbnail mt-1" style="max-height: 100px;">
                                </div>
                            @endif
                            @error('Imagen')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
            </form>
        </div>
    </div>
</div>