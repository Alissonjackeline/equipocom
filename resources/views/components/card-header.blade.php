<div class="card" id="card">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2"
        id="encabezado">
        <h5 class="mb-0 flex-md-grow-1">
            <i class="{{ $icon }}"></i>&nbsp;{{ $title }}
        </h5>
        
        @if(count($buttons) > 0)
            <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto justify-content-sm-end">
                @foreach($buttons as $button)
                    <a class="btn btn-{{ $button['variant'] ?? 'persona' }} btn-sm" href="{{ $button['route'] }}">
                        @if(isset($button['icon']))
                            <i class="{{ $button['icon'] }}"></i>
                        @endif
                        {{ $button['text'] }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="card-body">
        {{ $slot }}
    </div>
</div>