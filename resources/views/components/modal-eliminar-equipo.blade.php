@props([
    'equipment'
])

<div class="modal fade" id="modalEliminar{{ $equipment->idEquipment }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Seguro que deseas eliminar el equipo '{{ $equipment->CodigoPatri }}'?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('inventario.destroy', $equipment->idEquipment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>