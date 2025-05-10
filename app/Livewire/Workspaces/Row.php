<?php

namespace App\Livewire\Workspaces;

use Livewire\Component;

class Row extends Component
{
    public \App\Models\Workspace $workspace;
    public int $rownumber;

    public function render()
    {
        return view('livewire.workspaces.row');
    }
}
