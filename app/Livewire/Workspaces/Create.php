<?php

namespace App\Livewire\Workspaces;

use App\Livewire\Forms\WorkspaceForm;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public WorkspaceForm $form;
    
    public function save() 
    {
        $workspace = $this->form->store();
        
        $this->form->reset();

        $this->dispatch('workspaceCreated', $workspace->id);
    }

    public function render()
    {
        return view('livewire.workspaces.create');
    }
}
