<?php

namespace App\Livewire\Workspaces;

use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public bool $loadWorkspacesData = false; // Flag to control data loading

    #[On('workspaceCreated')]
    #[On('workspaceDeleted')]
    public function refreshList()
    {
        // If data has been loaded, reset to the first page to show changes accurately
        if ($this->loadWorkspacesData) {
            $this->resetPage();
        }
        // The component will automatically re-render due to the event,
        // and the render method will fetch fresh data.
    }

    public function loadWorkspaces()
    {
        // This method is called by wire:init
        $this->loadWorkspacesData = true;
    }

    public function render()
    {
        // sleep(3); // Simulate a delay for loading data, so you can see the placeholder in action
        $workspaces = null;
        if ($this->loadWorkspacesData) {
            $workspaces = Workspace::with('user')
                ->where('owner_id', Auth::id())
                ->latest()
                ->paginate(5);
        }

        return view('livewire.workspaces.index', [
            'workspacesForView' => $workspaces, // Pass the paginator (or null) to the view
        ]);
    }
}