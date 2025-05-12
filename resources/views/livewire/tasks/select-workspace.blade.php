<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Select Workspace</h5>
                </div>
                <div class="card-body">
                    @if($workspaces->isEmpty())
                        <div class="alert alert-info">
                            You don't have any workspaces yet. 
                            <a href="{{ route('workspaces.create') }}" class="alert-link">Create one</a>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($workspaces as $workspace)
                                <button 
                                    wire:click="selectWorkspace({{ $workspace->id }})"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                >
                                    <div>
                                        <h6 class="mb-1">{{ $workspace->name }}</h6>
                                        <small class="text-muted">{{ $workspace->description }}</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $workspace->tasks_count ?? 0 }} tasks
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> 