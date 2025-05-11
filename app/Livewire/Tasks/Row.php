<?php

namespace App\Livewire\Tasks;

use App\Livewire\Forms\TaskForm;
use App\Models\Task;
use Livewire\Component;

class Row extends Component
{
    public Task $task;
    public TaskForm $form;
    public bool $isEditing = false;

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
        if ($this->isEditing) {
            $this->form->title = $this->task->title;
            $this->form->description = $this->task->description;
            $this->form->status = $this->task->status;
            $this->form->scheduled_at = $this->task->scheduled_at?->format('Y-m-d');
            $this->form->due_at = $this->task->due_at?->format('Y-m-d');
            $this->form->assigned_to = $this->task->assigned_to;
        } else {
            $this->form->reset();
            $this->clearValidation();
        }
    }

    public function saveEdit()
    {
        $this->authorize('update', $this->task);

        $updatedTask = $this->form->update($this->task);

        if ($updatedTask) {
            $this->task->refresh();
            $this->isEditing = false;
            $this->dispatch('task-updated', message: 'Task updated successfully!');
        } else {
            $this->dispatch('task-error', message: 'Failed to update task.');
        }
    }

    public function deleteTask()
    {
        $this->authorize('delete', $this->task);
        $this->task->delete();
        $this->dispatch('task-deleted', message: 'Task deleted successfully!');
    }

    public function render()
    {
        return view('livewire.tasks.row');
    }
} 