@props([
    'id',
    'title',
    'size' => 'modal-sm',
    'headerClass' => '',
    'footer' => null
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog {{ $size }}">
        <div class="modal-content">
            <div class="modal-header {{ $headerClass }}" id="encabezado">
                <i class="fa-solid fa-images"></i><h1 class="modal-title fs-5" id="{{ $id }}Label"> {{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button
            </div>
        </div>
    </div>
</div>


