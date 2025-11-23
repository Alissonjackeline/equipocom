{{-- resources/views/components/modal-delete-assignment.blade.php --}}
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Seguro que deseas eliminar la asignación #{{ $assignmentId }}?</p>
                
                <p><strong>Esta acción:</strong></p>
                <ul>
                    <li>Eliminará la asignación permanentemente</li>
                    <li>Los equipos volverán a estado <strong>'Disponible'</strong></li>
                    <li>Se eliminarán los registros de relación</li>
                </ul>
                
                <div class="alert alert-warning">
                    <small>
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <strong>Importante:</strong> Los equipos asignados cambiarán su estado de "En uso" a "Disponible"
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ $action }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>