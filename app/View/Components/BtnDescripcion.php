<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BtnDescripcion extends Component
{
    /**
     * Create a new component instance.
     */public $id;
public $title;
public $size;
public $headerClass;
public $footer;

public function __construct($id = 'modalBase', $title = '', $size = null, $headerClass = null, $footer = null)
{
    $this->id = $id;
    $this->title = $title;
    $this->size = $size;
    $this->headerClass = $headerClass;
    $this->footer = $footer;
}


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.btn-descripcion');
    }
}