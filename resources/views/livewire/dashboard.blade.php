<div>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total Tasks (This Quarter)</h6>
                    <h2 class="mb-0">{{ $taskStats['total_this_quarter'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-muted">Due This Month</h6>
                    <div class="mt-3">
                        @forelse($taskStats['due_this_month_tasks'] as $task)
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-truncate" style="max-width: 150px;">{{ $task->title }}</h6>
                                    <small class="text-muted">{{ $task->workspace->name }}</small>
                                </div>
                                <a href="{{ route('workspaces.tasks.board', $task->workspace) }}" class="btn btn-sm btn-link">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No tasks due this month</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-muted">In Progress</h6>
                    <div class="mt-3">
                        @forelse($taskStats['in_progress_tasks'] as $task)
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-truncate" style="max-width: 150px;">{{ $task->title }}</h6>
                                    <small class="text-muted">{{ $task->workspace->name }}</small>
                                </div>
                                <a href="{{ route('workspaces.tasks.board', $task->workspace) }}" class="btn btn-sm btn-link">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No tasks in progress</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-muted">Completed (This Month)</h6>
                    <h2 class="mb-0">{{ $taskStats['completed_this_month'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    @forelse($recentActivity as $task)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $task->title }}</h6>
                                <small class="text-muted">
                                    {{ $task->workspace->name }} • 
                                    {{ $task->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <span class="badge bg-{{ $task->status === 'todo' ? 'secondary' : ($task->status === 'in_progress' ? 'primary' : 'success') }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No recent activity</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Upcoming Tasks</h5>
                </div>
                <div class="card-body">
                    @forelse($upcomingTasks as $task)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $task->title }}</h6>
                                <small class="text-muted">
                                    Due {{ $task->due_at->format('M d, Y') }} • 
                                    {{ $task->workspace->name }}
                                </small>
                            </div>
                            @if($task->assignee)
                                <small class="text-muted me-2">
                                    {{ $task->assignee->name }}
                                </small>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted mb-0">No upcoming tasks</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">My Tasks</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">To Do</h6>
                        @forelse($myTasks['todo'] as $task)
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $task->title }}</h6>
                                    <small class="text-muted">{{ $task->workspace->name }}</small>
                                </div>
                                <a 
                                    href="{{ route('workspaces.tasks.board', $task->workspace) }}" 
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    View Board
                                </a>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No tasks to do</p>
                        @endforelse
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-3">In Progress</h6>
                        @forelse($myTasks['in_progress'] as $task)
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $task->title }}</h6>
                                    <small class="text-muted">{{ $task->workspace->name }}</small>
                                </div>
                                <a 
                                    href="{{ route('workspaces.tasks.board', $task->workspace) }}" 
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    View Board
                                </a>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No tasks in progress</p>
                        @endforelse
                    </div>

                    <div>
                        <h6 class="text-muted mb-3">Done</h6>
                        @forelse($myTasks['done'] as $task)
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $task->title }}</h6>
                                    <small class="text-muted">{{ $task->workspace->name }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No completed tasks</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Workspaces</h5>
                </div>
                <div class="card-body">
                    @forelse($workspaces as $workspace)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $workspace->name }}</h6>
                                <small class="text-muted">
                                    {{ $workspace->tasks_count }} tasks • 
                                    {{ $workspace->members_count }} members
                                </small>
                            </div>
                            <a 
                                href="{{ route('workspaces.tasks.index', $workspace) }}" 
                                class="btn btn-sm btn-outline-primary"
                            >
                                View
                            </a>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No workspaces</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
