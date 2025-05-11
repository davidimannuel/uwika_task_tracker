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

    #[On('workspace-created')]
    #[On('workspace-updated')]
    #[On('workspace-deleted')]
    #[On('workspace-error')]
    public function handleAlert($message, $type = 'success')
    {
        $this->dispatch('show-alert', message: $message);
        
        if ($type === 'success') {
            $this->resetPage();
        }
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
            $workspaces = Workspace::query()
                ->with([
                    'creator:id,name,email',
                    'members' => function ($query) {
                        $query->select('id', 'workspace_id', 'user_id', 'role')
                            ->with('user:id,name,email');
                    }
                ])
                ->whereHas('members', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->latest()
                ->paginate(5);
        }

        return view('livewire.workspaces.index', [
            'workspacesForView' => $workspaces, // Pass the paginator (or null) to the view
        ]);
    }
}