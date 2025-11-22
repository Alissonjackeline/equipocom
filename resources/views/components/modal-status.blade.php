@props([
    'id',
    'message',
    'action',
    'confirmClass' => 'btn-danger',
    'confirmText' => 'Confirmar',
    'method' => 'DELETE' // Prop nueva
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{ $message }}</p>
            </div>
            <div class="modal-footer">
                <form action="{{ $action }}" method="POST">
                    @csrf
                    @method($method) {{-- Usa la prop method --}}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn {{ $confirmClass }}">{{ $confirmText }}</button>
                </form>
            </div>
        </div>
    </div>
</div>