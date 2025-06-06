<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 flex-grow-1">
            <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                <label class="form-label mb-0 me-2">Workspace:</label>
                <form wire:submit.prevent="selectWorkspace" class="d-flex align-items-center gap-2 mb-0">
                    <select 
                        wire:model="workspaceId" 
                        class="form-select form-select-sm"
                        style="width: 160px;"
                    >
                        @foreach($workspaces as $ws)
                            <option value="{{ $ws->id }}">{{ $ws->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-outline-success btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;" title="Select Workspace">
                        <i class="bi bi-check"></i>
                    </button>
                </form>
            </div>

            <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                <label class="form-label mb-0 me-2">Assigned To:</label>
                <div class="d-flex align-items-center gap-2">
                    <select 
                        wire:model.live="filterAssignee" 
                        class="form-select form-select-sm"
                        style="width: 160px;"
                    >
                        <option value="">All Users</option>
                        @foreach($workspace->members as $member)
                            <option value="{{ $member->user->id }}">{{ $member->user->name }} ({{ $member->role }})</option>
                        @endforeach
                    </select>
                    @if($filterAssignee)
                        <button 
                            wire:click="clearAssigneeFilter"
                            class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                            style="width:32px;height:32px;" 
                            title="Clear Filter"
                        >
                            <i class="bi bi-x"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('workspaces.tasks.index', $workspace) }}" class="btn btn-outline-primary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;" title="List View">
                <i class="bi bi-list"></i>
            </a>
            <button 
                wire:click="$set('showCreateForm', true)"
                class="btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center"
                style="width:32px;height:32px;"
                title="New Task"
            >
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0">Date Filters</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Scheduled Date Range</label>
                        <div class="d-flex align-items-center gap-2">
                            <input 
                                type="date" 
                                wire:model="filterStartDate" 
                                class="form-control form-control-sm"
                            >
                            <span class="mx-1">to</span>
                            <input 
                                type="date" 
                                wire:model="filterEndDate" 
                                class="form-control form-control-sm"
                            >
                            @if($filterStartDate || $filterEndDate)
                                <button 
                                    wire:click="clearScheduledDateFilter"
                                    class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width:32px;height:32px;" 
                                    title="Clear Scheduled Date Filter"
                                >
                                    <i class="bi bi-x"></i>
                                </button>
                            @endif
                        </div>
                        <div class="btn-group btn-group-sm mt-2">
                            <button type="button" class="btn btn-outline-secondary" wire:click="setDateRange('this_week')">This Week</button>
                            <button type="button" class="btn btn-outline-secondary" wire:click="setDateRange('this_month')">This Month</button>
                            <button type="button" class="btn btn-outline-secondary" wire:click="setDateRange('this_quarter')">This Quarter</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Due Date Range</label>
                        <div class="d-flex align-items-center gap-2">
                            <input 
                                type="date" 
                                wire:model="filterDueStartDate" 
                                class="form-control form-control-sm"
                            >
                            <span class="mx-1">to</span>
                            <input 
                                type="date" 
                                wire:model="filterDueEndDate" 
                                class="form-control form-control-sm"
                            >
                            @if($filterDueStartDate || $filterDueEndDate)
                                <button 
                                    wire:click="clearDueDateFilter"
                                    class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width:32px;height:32px;" 
                                    title="Clear Due Date Filter"
                                >
                                    <i class="bi bi-x"></i>
                                </button>
                            @endif
                        </div>
                        <div class="btn-group btn-group-sm mt-2">
                            <button type="button" class="btn btn-outline-secondary" wire:click="setDueDateRange('this_week')">This Week</button>
                            <button type="button" class="btn btn-outline-secondary" wire:click="setDueDateRange('this_month')">This Month</button>
                            <button type="button" class="btn btn-outline-secondary" wire:click="setDueDateRange('this_quarter')">This Quarter</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button 
                    wire:click="clearAllFilters"
                    class="btn btn-outline-secondary btn-sm"
                >
                    Clear All Filters
                </button>
            </div>
        </div>
    </div>

    @if($showCreateForm)
        <div class="mb-4">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Task</h5>
                    <button class="btn btn-sm btn-outline-secondary" wire:click="closeCreateForm">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="card-body">
                    <livewire:tasks.create :workspace="$workspace" :taskToDuplicate="$taskToDuplicate" />
                </div>
            </div>
        </div>
    @endif

    @if($editingTask)
        <div class="mb-4">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Task</h5>
                    <button class="btn btn-sm btn-outline-secondary" wire:click="closeEditForm">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="card-body">
                    <livewire:tasks.edit :task="$editingTask" :key="'edit-'.$editingTask->id" />
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">To Do</h5>
                </div>
                <div class="card-body">
                    @foreach($groupedTasks['todo'] as $task)
                        @php
                            $canUpdateStatus = auth()->user()->can('updateStatus', $task);
                            $nextStatus = $task->status === 'todo' ? 'in_progress' : ($task->status === 'in_progress' ? 'done' : ($task->status === 'done' ? 'closed' : null));
                            $nextLabel = $task->status === 'todo' ? 'Start' : ($task->status === 'in_progress' ? 'Done' : ($task->status === 'done' ? 'Close' : ''));
                        @endphp

                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1">{{ $task->title }}</h6>
                                        @if($canUpdateStatus && $nextStatus)
                                            <button
                                                class="btn btn-sm btn-outline-success mt-2"
                                                wire:click="updateTaskStatus({{ $task->id }}, '{{ $nextStatus }}')"
                                                wire:confirm="Are you sure you want to mark this task as {{ ucfirst($nextStatus) }}?"
                                            >
                                                {{ $nextLabel }}
                                            </button>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1 align-items-start">
                                        <button 
                                            class="btn btn-link btn-sm text-dark p-0"
                                            wire:click="editTask({{ json_encode(['taskId' => $task->id]) }})"
                                            title="View"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button 
                                            class="btn btn-link btn-sm text-primary p-0"
                                            wire:click="duplicateTask({{ $task->id }})"
                                            title="Duplicate"
                                        >
                                            <i class="bi bi-files"></i>
                                        </button>
                                        <button 
                                            class="btn btn-link btn-sm text-danger p-0"
                                            wire:confirm="Are you sure you want to delete this?"
                                            wire:click="deleteTask({{ $task->id }})"
                                            title="Delete"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <p class="card-text small text-muted mb-2">
                                    {{ Str::limit($task->description, 100) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Scheduled: {{ $task->scheduled_at?->format('M d, Y') ?? 'No scheduled date' }}
                                    </small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Due: {{ $task->due_at?->format('M d, Y') ?? 'No due date' }}
                                    </small>
                                    @if($task->assignee)
                                        <small class="text-muted">
                                            Assigned to: {{ $task->assignee->name }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">In Progress</h5>
                </div>
                <div class="card-body">
                    @foreach($groupedTasks['in_progress'] as $task)
                        @php
                            $canUpdateStatus = auth()->user()->can('updateStatus', $task);
                            $nextStatus = $task->status === 'todo' ? 'in_progress' : ($task->status === 'in_progress' ? 'done' : ($task->status === 'done' ? 'closed' : null));
                            $nextLabel = $task->status === 'todo' ? 'Start' : ($task->status === 'in_progress' ? 'Done' : ($task->status === 'done' ? 'Close' : ''));
                        @endphp

                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1">{{ $task->title }}</h6>
                                        @if($canUpdateStatus && $nextStatus)
                                            <button
                                                class="btn btn-sm btn-outline-success mt-2"
                                                wire:click="updateTaskStatus({{ $task->id }}, '{{ $nextStatus }}')"
                                                wire:confirm="Are you sure you want to mark this task as {{ ucfirst($nextStatus) }}?"
                                            >
                                                {{ $nextLabel }}
                                            </button>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1 align-items-start">
                                        <button 
                                            class="btn btn-link btn-sm text-dark p-0"
                                            wire:click="editTask({{ json_encode(['taskId' => $task->id]) }})"
                                            title="View"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button 
                                            class="btn btn-link btn-sm text-primary p-0"
                                            wire:click="duplicateTask({{ $task->id }})"
                                            title="Duplicate"
                                        >
                                            <i class="bi bi-files"></i>
                                        </button>
                                        <button 
                                            class="btn btn-link btn-sm text-danger p-0"
                                            wire:confirm="Are you sure you want to delete this?"
                                            wire:click="deleteTask({{ $task->id }})"
                                            title="Delete"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <p class="card-text small text-muted mb-2">
                                    {{ Str::limit($task->description, 100) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Scheduled: {{ $task->scheduled_at?->format('M d, Y') ?? 'No scheduled date' }}
                                    </small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Due: {{ $task->due_at?->format('M d, Y') ?? 'No due date' }}
                                    </small>
                                    @if($task->assignee)
                                        <small class="text-muted">
                                            Assigned to: {{ $task->assignee->name }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Done</h5>
                </div>
                <div class="card-body">
                    @foreach($groupedTasks['done'] as $task)
                        @php
                            $canUpdateStatus = auth()->user()->can('updateStatus', $task);
                            $nextStatus = $task->status === 'todo' ? 'in_progress' : ($task->status === 'in_progress' ? 'done' : ($task->status === 'done' ? 'closed' : null));
                            $nextLabel = $task->status === 'todo' ? 'Start' : ($task->status === 'in_progress' ? 'Done' : ($task->status === 'done' ? 'Close' : ''));
                        @endphp

                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1">{{ $task->title }}</h6>
                                        @if($canUpdateStatus && $nextStatus)
                                            <button
                                                class="btn btn-sm btn-outline-success mt-2"
                                                wire:click="updateTaskStatus({{ $task->id }}, '{{ $nextStatus }}')"
                                                wire:confirm="Are you sure you want to mark this task as {{ ucfirst($nextStatus) }}?"
                                            >
                                                {{ $nextLabel }}
                                            </button>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1 align-items-start">
                                        <button 
                                            class="btn btn-link btn-sm text-dark p-0"
                                            wire:click="editTask({{ json_encode(['taskId' => $task->id]) }})"
                                            title="View"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button 
                                            class="btn btn-link btn-sm text-primary p-0"
                                            wire:click="duplicateTask({{ $task->id }})"
                                            title="Duplicate"
                                        >
                                            <i class="bi bi-files"></i>
                                        </button>
                                        <button 
                                            class="btn btn-link btn-sm text-danger p-0"
                                            wire:confirm="Are you sure you want to delete this?"
                                            wire:click="deleteTask({{ $task->id }})"
                                            title="Delete"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <p class="card-text small text-muted mb-2">
                                    {{ Str::limit($task->description, 100) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Scheduled: {{ $task->scheduled_at?->format('M d, Y') ?? 'No scheduled date' }}
                                    </small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Due: {{ $task->due_at?->format('M d, Y') ?? 'No due date' }}
                                    </small>
                                    @if($task->assignee)
                                        <small class="text-muted">
                                            Assigned to: {{ $task->assignee->name }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        // Initialize Bootstrap dropdowns
        document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(dropdownToggle => {
            new bootstrap.Dropdown(dropdownToggle);
        });
    });
</script>
@endpush 