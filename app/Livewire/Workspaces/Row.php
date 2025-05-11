<?php

namespace App\Livewire\Workspaces;

use App\Livewire\Forms\WorkspaceForm;
use Livewire\Component;

class Row extends Component
{
    public \App\Models\Workspace $workspace;

    public WorkspaceForm $form; 

    public bool $isEditing = false;

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
        if ($this->isEditing) {
            // Populate the form with the current workspace's data
            $this->form->name = $this->workspace->name;
            $this->form->description = $this->workspace->description;
        } else {
            $this->form->reset(); // Reset form if canceling edit
            $this->clearValidation(); // Clear any previous validation errors
        }
    }

    public function saveEdit()
    {
        $this->authorize('update', $this->workspace);

        $updatedWorkspace = $this->form->update($this->workspace);

        if ($updatedWorkspace) {
            $this->workspace->refresh(); // Refresh the model data
            $this->isEditing = false;
            session()->flash('status', 'Workspace updated successfully!');
        } else {
            session()->flash('error', 'Failed to update workspace.');
        }
    }

    public function deleteWorkspace()
    {
        $this->authorize('delete', $this->workspace);
        $this->workspace->delete();
        $this->dispatch('workspaceDeleted', $this->workspace->id);
        session()->flash('status', 'Workspace deleted successfully!');
    }

    public function render()
    {
        return view('livewire.workspaces.row');
    }
}
