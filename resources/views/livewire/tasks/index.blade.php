<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tasks</h2>
        <button class="btn btn-primary" wire:click="$toggle('showCreateForm')">
            <i class="bi bi-plus-lg"></i> New Task
        </button>
    </div>

    <div class="mb-4" x-data="{ show: @entangle('showCreateForm') }" x-show="show" x-transition>
        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Create New Task</h5>
                <button class="btn btn-sm btn-outline-secondary" wire:click="$toggle('showCreateForm')">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="card-body">
                <livewire:tasks.create :workspace="$workspace" />
            </div>
        </div>
    </div>

    <div wire:init="loadTasks">
        @if (!$loadTasksData)
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">To Do</h5>
                        </div>
                        <div class="card-body">
                            @forelse ($groupedTasks['todo'] as $task)
                                <livewire:tasks.row :task="$task" :key="'todo-'.$task->id" />
                            @empty
                                <p class="text-muted">No tasks in To Do.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">In Progress</h5>
                        </div>
                        <div class="card-body">
                            @forelse ($groupedTasks['in_progress'] as $task)
                                <livewire:tasks.row :task="$task" :key="'inprogress-'.$task->id" />
                            @empty
                                <p class="text-muted">No tasks in Progress.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Done</h5>
                        </div>
                        <div class="card-body">
                            @forelse ($groupedTasks['done'] as $task)
                                <livewire:tasks.row :task="$task" :key="'done-'.$task->id" />
                            @empty
                                <p class="text-muted">No tasks Done.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @script
    <script>
        $wire.on('show-alert', (event) => {
            alert(event.message);
        });
    </script>
    @endscript
</div> 