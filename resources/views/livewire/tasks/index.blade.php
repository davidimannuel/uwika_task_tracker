<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Tasks of {{ $workspace->name }}</h2>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('workspaces.tasks.board', $workspace) }}" class="btn btn-primary">
                <i class="bi bi-kanban"></i> Board View
            </a>
            <button class="btn btn-primary" wire:click="$toggle('showCreateForm')">
                <i class="bi bi-plus-lg"></i> New Task
            </button>
        </div>
    </div>

    @if($showCreateForm)
        <div class="mb-4">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Task</h5>
                    <button class="btn btn-sm btn-secondary" wire:click="$toggle('showCreateForm')">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="card-body">
                    <livewire:tasks.create :workspace="$workspace" />
                </div>
            </div>
        </div>
    @endif

    @if($editingTask)
        <div class="mb-4">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Task</h5>
                    <button class="btn btn-sm btn-secondary" wire:click="closeEditForm">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="card-body">
                    <livewire:tasks.edit :task="$editingTask" :key="'edit-'.$editingTask->id" />
                </div>
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-light">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" wire:model="status">
                        <option value="">All Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Scheduled At Start</label>
                    <input type="date" class="form-control" wire:model="scheduledAtStart" placeholder="Start Date">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Scheduled At End</label>
                    <input type="date" class="form-control" wire:model="scheduledAtEnd" placeholder="End Date">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" class="form-control" wire:model="dueDate" placeholder="Due Date">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-primary" wire:click="applyFilters">Apply Filter</button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Scheduled</th>
                            <th>Due</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>
                                    <span class="badge bg-{{ $task->status === 'todo' ? 'secondary' : ($task->status === 'in_progress' ? 'primary' : ($task->status === 'done' ? 'success' : 'dark')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>
                                <td>{{ $task->assignee?->name ?? 'Unassigned' }}</td>
                                <td>{{ $task->scheduled_at?->format('M d, Y') }}</td>
                                <td>{{ $task->due_at?->format('M d, Y') }}</td>
                                <td>{{ $task->creator->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary" wire:click="editTask({{ $task->id }})" title="View">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button 
                                            type="button" class="btn btn-sm btn-danger" 
                                            wire:confirm="Are you sure you want to delete this?"
                                            wire:click="deleteTask({{ $task->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No tasks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('show-alert', (event) => {
            alert(event.message);
        });
    </script>
    @endscript
</div> 