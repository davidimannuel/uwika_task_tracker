<?php

namespace App\Livewire\Forms;

use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Form;

class TaskForm extends Form
{
    #[Rule('required', 'string', 'min:3')]
    public string $title = '';

    #[Rule('nullable', 'string')]
    public ?string $description = '';

    #[Rule('required', 'string', 'in:todo,in_progress,done,closed')]
    public string $status = 'todo';

    #[Rule('nullable', 'date')]
    public ?string $scheduled_at = null;

    #[Rule('nullable', 'date')]
    public ?string $due_at = null;

    #[Rule('nullable', 'exists:users,id')]
    public ?int $assigned_to = null;

    public function store(Workspace $workspace)
    {
        $validated = $this->validate();

        $task = $workspace->tasks()->create([
            ...$validated,
            'created_by' => Auth::id(),
            'status' => $validated['status'] ?? 'todo',
        ]);

        $this->reset();

        session()->flash('success-create', "Task created successfully.");

        return $task;
    }

    public function update(Task $task)
    {
        $validated = $this->validate();
        $oldStatus = $task->status;
        $newStatus = $validated['status'] ?? $oldStatus;

        // Handle status changes and timestamps
        if ($oldStatus !== $newStatus) {
            switch ($newStatus) {
                case 'in_progress':
                    $validated['started_at'] = now();
                    break;
                case 'done':
                    $validated['finished_at'] = now();
                    break;
                case 'closed':
                    $validated['closed_at'] = now();
                    break;
            }
        }

        $task->fill($validated);
        $task->save();

        $this->reset();

        return $task;
    }
} 