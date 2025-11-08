<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DataTable extends Component
{
    public $columns;
    public $data;
    public $tableId;

    public function __construct($columns = [], $data = [], $tableId = 'example')
    {
        $this->columns = $columns;
        $this->data = $data;
        $this->tableId = $tableId;
    }

    public function render()
    {
        return view('components.data-table');
    }
}