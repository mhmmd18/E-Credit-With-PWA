<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LogsTable extends Component
{
    public $catatan;
    public $totalCicilan;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($catatan, $totalCicilan = null)
    {
        $this->catatan = $catatan;
        $this->totalCicilan = $totalCicilan;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.logs-table');
    }
}
