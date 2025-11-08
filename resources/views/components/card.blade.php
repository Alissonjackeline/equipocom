<div class="col-12 col-md-3 pt-1">
    <div class="card {{ $bgColor }}" id="tarjeta">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div class="col-3">
                <div class="d-flex justify-content-start">
                    <i class="{{ $icon }} text-light" style="font-size: 40px;"></i>
                </div>
            </div>
            <div class="col-3">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="card-title text-light">{{ $title }}</h6>
                </div>
            </div>
            <div class="col-3">
                <div class="d-flex justify-content-end">
                    <h1 class="card-title text-light text-center">{{ $value }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
