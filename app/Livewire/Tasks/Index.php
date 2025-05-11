<?php

namespace App\Livewire\Tasks;

use App\Models\Workspace;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Workspace $workspace;
    public bool $loadTasksData = false;
    public bool $showCreateForm = false;

    #[On('task-created')]
    #[On('task-updated')]
    #[On('task-deleted')]
    #[On('task-error')]
    public function handleAlert($message, $type = 'success')
    {
        $this->dispatch('show-alert', message: $message);
        
        if ($type === 'success') {
            $this->resetPage();
            $this->showCreateForm = false;
        }
    }

    public function loadTasks()
    {
        $this->loadTasksData = true;
    }

    public function render()
    {
        $tasks = null;
        if ($this->loadTasksData) {
            $tasks = $this->workspace->tasks()
                ->with([
                    'creator:id,name,email',
                    'assignee:id,name,email'
                ])
                ->latest()
                ->get();
        }

        $groupedTasks = [
            'todo' => [],
            'in_progress' => [],
            'done' => [],
        ];

        if ($tasks) {
            $groupedTasks = [
                'todo' => $tasks->where('status', 'todo')->all(),
                'in_progress' => $tasks->where('status', 'in_progress')->all(),
                'done' => $tasks->where('status', 'done')->all(),
            ];
        }

        return view('livewire.tasks.index', [
            'groupedTasks' => $groupedTasks,
        ]);
    }
} 