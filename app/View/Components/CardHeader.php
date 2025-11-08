<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardHeader extends Component
{
    public $title;
    public $icon;
    public $buttons;

    public function __construct($title, $icon = 'fa-solid fa-circle', $buttons = [])
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->buttons = $buttons;
    }

    public function render()
    {
        return view('components.card-header');
    }
}