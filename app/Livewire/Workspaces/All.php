<?php

namespace App\Livewire\Workspaces;

use Livewire\Component;
use Livewire\Attributes\On; 
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;

class All extends Component
{
    use \Livewire\WithPagination;

    #[On('workspaceCreated')]
    public function updateList($workspace)
    {
        
    }

    public function placeholder()
    {
        return view('livewire.workspaces.placeholder');
    }

    public function render()
    {
        // sleep(3); // Simulate a slow loading time for check the placeholder
        $workspaces = Workspace::with('user')->
            where('owner_id', Auth::id())->latest()->paginate(5);

        return view('livewire.workspaces.all',[
            'workspaces' => $workspaces,
        ]);
    }
}
