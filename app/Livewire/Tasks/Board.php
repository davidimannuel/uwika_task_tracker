<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Board extends Component
{
    public ?string $startDate = null;
    public ?string $endDate = null;
    public bool $showCreateForm = false;
    public ?Task $editingTask = null;
    public $workspaceId;
    public $filterStartDate;
    public $filterEndDate;

    public function mount()
    {
        $workspaces = Workspace::whereHas('members', function($q) {
            $q->where('user_id', Auth::id());
        })->get();

        if ($workspaces->count()) {
            $this->workspaceId = $workspaces->first()->id;
        }

        $this->startDate = now()->subWeeks(2)->format('Y-m-d');
        $this->endDate = now()->addWeeks(2)->format('Y-m-d');
        $this->filterStartDate = $this->startDate;
        $this->filterEndDate = $this->endDate;
    }

    public function selectWorkspace()
    {
        $this->editingTask = null;
        $this->showCreateForm = false;
    }

    public function applyFilters()
    {
        $this->startDate = $this->filterStartDate;
        $this->endDate = $this->filterEndDate;
    }

    public function closeCreateForm()
    {
        $this->showCreateForm = false;
    }

    #[On('close-edit-form')]
    public function handleCloseEditForm()
    {
        $this->editingTask = null;
    }

    public function closeEditForm()
    {
        $this->editingTask = null;
    }

    public function updateTaskStatus($taskId, $status)
    {
        $task = Task::find($taskId);
        if ($task) {
            $this->authorize('update', $task);

            $oldStatus = $task->status;
            $task->status = $status;

            if ($oldStatus !== $status) {
                switch ($status) {
                    case 'in_progress':
                        $task->started_at = now();
                        break;
                    case 'done':
                        $task->finished_at = now();
                        break;
                    case 'closed':
                        $task->closed_at = now();
                        break;
                }
            }

            $task->save();
            $this->dispatch('task-updated', message: 'Task status updated successfully!');
        }
    }

    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $this->authorize('delete', $task);
            $task->delete();
            $this->dispatch('task-deleted', message: 'Task deleted successfully');
        }
    }

    #[On('edit-task')]
    public function editTask($data)
    {
        $this->editingTask = Task::find($data['taskId']);
    }

    #[On('task-created')]
    #[On('task-updated')]
    #[On('task-deleted')]
    #[On('task-error')]
    public function handleAlert($message, $type = 'success')
    {
        $this->dispatch('show-alert', message: $message);

        if ($type === 'success') {
            $this->showCreateForm = false;
            $this->editingTask = null;
        }
    }

    public function render()
    {
        $workspaces = Workspace::whereHas('members', function($q) {
            $q->where('user_id', Auth::id());
        })->get();

        $workspace = $workspaces->where('id', $this->workspaceId)->first();

        if (!$workspace) {
            return view('livewire.tasks.select-workspace', [
                'workspaces' => $workspaces,
            ]);
        }

        $query = $workspace->tasks()
            ->with(['creator:id,name,email', 'assignee:id,name,email'])
            ->whereNotIn('status', ['closed']);

        if ($this->startDate) {
            $query->where('scheduled_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->where('scheduled_at', '<=', $this->endDate);
        }

        $tasks = $query->get()->sortBy('scheduled_at');

        $groupedTasks = [
            'todo' => $tasks->where('status', 'todo')->all(),
            'in_progress' => $tasks->where('status', 'in_progress')->all(),
            'done' => $tasks->where('status', 'done')->all(),
        ];

        return view('livewire.tasks.board', [
            'workspaces' => $workspaces,
            'workspace' => $workspace,
            'groupedTasks' => $groupedTasks,
        ]);
    }
} 