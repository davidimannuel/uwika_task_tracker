<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Workspace;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Workspace $workspace;
    public ?string $status = null;
    public ?string $scheduledAtStart = null;
    public ?string $scheduledAtEnd = null;
    public ?string $dueDate = null;
    public string $orderBy = 'created_at';
    public string $orderDirection = 'desc';
    public bool $showCreateForm = false;
    public ?Task $editingTask = null;

    public function mount(Workspace $workspace)
    {
        $this->workspace = $workspace;
        $this->scheduledAtStart = Carbon::now()->subMonths(3)->format('Y-m-d');
        $this->scheduledAtEnd = Carbon::now()->addMonths(3)->format('Y-m-d');
    }

    public function updatedOrderBy()
    {
        $this->resetPage();
    }

    public function updatedOrderDirection()
    {
        $this->resetPage();
    }

    #[On('edit-task')]
    public function editTask($data)
    {
        $this->editingTask = Task::find($data);
    }

    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->delete();
            $this->dispatch('task-deleted', message: 'Task deleted successfully');
        }
    }

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
            $this->editingTask = null;
        }
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

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = $this->workspace->tasks()
            ->with([
                'creator:id,name,email',
                'assignee:id,name,email'
            ]);

        // Apply status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Apply date range filter
        if ($this->scheduledAtStart) {
            $query->where('scheduled_at', '>=', $this->scheduledAtStart);
        }
        if ($this->scheduledAtEnd) {
            $query->where('scheduled_at', '<=', $this->scheduledAtEnd);
        }

        // Apply due date filter
        if ($this->dueDate) {
            $query->whereDate('due_at', $this->dueDate);
        }

        // Apply ordering
        $query->orderBy($this->orderBy, $this->orderDirection);

        $tasks = $query->paginate(10);

        return view('livewire.tasks.index', [
            'tasks' => $tasks,
            'statuses' => ['todo', 'in_progress', 'done', 'closed'],
        ]);
    }
} 