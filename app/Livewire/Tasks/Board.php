<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Carbon\Carbon;

class Board extends Component
{
    public $workspaceId;
    public $workspace;
    public $showCreateForm = false;
    public $editingTask = null;
    public $taskToDuplicate = null;
    public $filterAssignee = '';
    public $filterStartDate = '';
    public $filterEndDate = '';
    public $filterDueStartDate = '';
    public $filterDueEndDate = '';
    public $groupedTasks = [];

    public function mount()
    {
        $this->workspaceId = Auth::user()->workspaces()->first()?->workspace_id;
        if ($this->workspaceId) {
            $this->workspace = Workspace::findOrFail($this->workspaceId);
            $this->groupedTasks = [
                'todo' => [],
                'in_progress' => [],
                'done' => []
            ];

            // Set default date range (1 week back and 1 week ahead)
            $this->filterStartDate = now()->subWeek()->format('Y-m-d');
            $this->filterEndDate = now()->addWeek()->format('Y-m-d');
            
            $this->applyFilters();
        }
    }

    public function setDateRange($range)
    {
        switch ($range) {
            case 'this_week':
                $this->filterStartDate = now()->startOfWeek()->format('Y-m-d');
                $this->filterEndDate = now()->endOfWeek()->format('Y-m-d');
                break;
            case 'this_month':
                $this->filterStartDate = now()->startOfMonth()->format('Y-m-d');
                $this->filterEndDate = now()->endOfMonth()->format('Y-m-d');
                break;
            case 'this_quarter':
                $this->filterStartDate = now()->startOfQuarter()->format('Y-m-d');
                $this->filterEndDate = now()->endOfQuarter()->format('Y-m-d');
                break;
        }
        $this->applyFilters();
    }

    public function setDueDateRange($range)
    {
        switch ($range) {
            case 'this_week':
                $this->filterDueStartDate = now()->startOfWeek()->format('Y-m-d');
                $this->filterDueEndDate = now()->endOfWeek()->format('Y-m-d');
                break;
            case 'this_month':
                $this->filterDueStartDate = now()->startOfMonth()->format('Y-m-d');
                $this->filterDueEndDate = now()->endOfMonth()->format('Y-m-d');
                break;
            case 'this_quarter':
                $this->filterDueStartDate = now()->startOfQuarter()->format('Y-m-d');
                $this->filterDueEndDate = now()->endOfQuarter()->format('Y-m-d');
                break;
        }
        $this->applyFilters();
    }

    public function clearScheduledDateFilter()
    {
        $this->filterStartDate = null;
        $this->filterEndDate = null;
    }

    public function clearDueDateFilter()
    {
        $this->filterDueStartDate = null;
        $this->filterDueEndDate = null;
    }

    public function clearAllFilters()
    {
        $this->filterAssignee = '';
        $this->filterStartDate = null;
        $this->filterEndDate = null;
        $this->filterDueStartDate = null;
        $this->filterDueEndDate = null;
    }

    public function applyFilters()
    {
        if (!$this->workspace) {
            return;
        }

        $query = $this->workspace->tasks()
            ->with(['creator:id,name,email', 'assignee:id,name,email'])
            ->whereNotIn('status', ['closed']);

        if ($this->filterAssignee) {
            $query->where('assigned_to', $this->filterAssignee);
        }

        // Scheduled date range filter
        if ($this->filterStartDate && $this->filterEndDate) {
            $startDate = Carbon::parse($this->filterStartDate)->startOfDay();
            $endDate = Carbon::parse($this->filterEndDate)->endOfDay();
            $query->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('scheduled_at', [$startDate, $endDate])
                  ->orWhereNull('scheduled_at');
            });
        }

        // Due date range filter
        if ($this->filterDueStartDate && $this->filterDueEndDate) {
            $dueStartDate = Carbon::parse($this->filterDueStartDate)->startOfDay();
            $dueEndDate = Carbon::parse($this->filterDueEndDate)->endOfDay();
            $query->where(function($q) use ($dueStartDate, $dueEndDate) {
                $q->whereBetween('due_at', [$dueStartDate, $dueEndDate])
                  ->orWhereNull('due_at');
            });
        }

        $tasks = $query->get()->sortBy('scheduled_at');

        $this->groupedTasks = [
            'todo' => $tasks->where('status', 'todo')->values()->all(),
            'in_progress' => $tasks->where('status', 'in_progress')->values()->all(),
            'done' => $tasks->where('status', 'done')->values()->all()
        ];
    }

    public function selectWorkspace()
    {
        $this->editingTask = null;
        $this->showCreateForm = false;
        $this->filterAssignee = '';
        $this->taskToDuplicate = null;
        
        // Update workspace
        $this->workspace = Workspace::findOrFail($this->workspaceId);
        
        // Reset date filters to default range
        $this->filterStartDate = now()->subWeek()->format('Y-m-d');
        $this->filterEndDate = now()->addWeek()->format('Y-m-d');
        $this->filterDueStartDate = '';
        $this->filterDueEndDate = '';
        
        // Apply filters with new workspace
        $this->applyFilters();
    }

    public function clearAssigneeFilter()
    {
        $this->filterAssignee = '';
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
            $this->applyFilters();
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
            $this->taskToDuplicate = null;
            $this->applyFilters();
        }
    }

    public function duplicateTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $this->authorize('create', [Task::class, $task->workspace]);

        $this->taskToDuplicate = $task;
        $this->showCreateForm = true;
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

        if ($this->filterStartDate && $this->filterEndDate) {
            $query->whereBetween('scheduled_at', [
                Carbon::parse($this->filterStartDate)->startOfDay(),
                Carbon::parse($this->filterEndDate)->endOfDay()
            ]);
        }

        if ($this->filterDueStartDate && $this->filterDueEndDate) {
            $query->whereBetween('due_at', [
                Carbon::parse($this->filterDueStartDate)->startOfDay(),
                Carbon::parse($this->filterDueEndDate)->endOfDay()
            ]);
        }

        if ($this->filterAssignee) {
            $query->where('assigned_to', $this->filterAssignee);
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