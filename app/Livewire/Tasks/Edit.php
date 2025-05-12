<?php

namespace App\Livewire\Tasks;

use App\Livewire\Forms\TaskForm;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public Task $task;
    public TaskForm $form;

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->form->title = $task->title;
        $this->form->description = $task->description;
        $this->form->status = $task->status ?? 'todo';
        $this->form->scheduled_at = $task->scheduled_at?->format('Y-m-d');
        $this->form->due_at = $task->due_at?->format('Y-m-d');
        $this->form->assigned_to = $task->assigned_to;
    }

    public function save()
    {
        $this->authorize('update', $this->task);

        $updatedTask = $this->form->update($this->task);

        if ($updatedTask) {
            $this->dispatch('task-updated', message: 'Task updated successfully!');
        } else {
            $this->dispatch('task-error', message: 'Failed to update task.');
        }
    }

    public function render()
    {
        $isAuthorized = Auth::user()->can('update', $this->task);
        return view('livewire.tasks.edit', [
            'users' => $this->task->workspace->members->pluck('user'),
            'isAuthorized' => $isAuthorized,
        ]);
    }
} 