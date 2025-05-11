<?php

namespace App\Livewire\Workspaces;

use App\Livewire\Forms\WorkspaceForm;
use Livewire\Component;

class Row extends Component
{
    public \App\Models\Workspace $workspace;
    public int $rownumber;

    public WorkspaceForm $form; 


    public bool $isEditing = false;

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
        if ($this->isEditing) {
            // Populate the form with the current workspace's data
            $this->form->name = $this->workspace->name;
            // If your WorkspaceForm had other properties, set them here:
            // $this->form->someOtherProperty = $this->workspace->some_other_column;
        } else {
            $this->form->reset(); // Reset form if canceling edit
            $this->clearValidation(); // Clear any previous validation errors
        }
    }

    public function saveEdit()
    {
        $this->authorize('update', $this->workspace);

        // The validation rules are in WorkspaceForm.
        // We need a way to pass the workspace instance to the form's update method.
        // Let's assume you'll add an `update` method to WorkspaceForm.
        $updatedWorkspace = $this->form->update($this->workspace);

        if ($updatedWorkspace) {
            $this->workspace->refresh(); // Refresh the model data
            $this->isEditing = false;
            session()->flash('status', 'Workspace updated successfully!');
        } else {
            // Handle update failure if necessary, though validation should catch most issues
            session()->flash('error', 'Failed to update workspace.');
        }
    }

    public function confirmDelete()
    {
        $this->authorize('delete', $this->workspace);
        // This will trigger the wire:confirm dialog in the Blade view
    }

    public function deleteWorkspace()
    {
        $this->authorize('delete', $this->workspace);
        $this->workspace->delete();
        $this->dispatch('workspaceDeleted'); // Notify parent to refresh
        session()->flash('status', 'Workspace deleted successfully!');
    }

    public function render()
    {
        return view('livewire.workspaces.row');
    }
}
