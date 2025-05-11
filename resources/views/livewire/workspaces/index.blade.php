<div>
    {{-- Create form component loads immediately --}}
    <livewire:workspaces.create />

    <hr>

    {{-- Display status messages --}}
    @if (session()->has('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- List of workspaces section - will be lazy-loaded --}}
    <div wire:init="loadWorkspaces">
        @if ($workspacesForView)
            <div class="mt-4">
                <h3>Your Workspaces</h3>
                @forelse ($workspacesForView as $workspace)
                    <livewire:workspaces.row
                        :workspace="$workspace"
                        wire:key="workspace-row-{{ $workspace->id }}" />
                @empty
                    <p>No workspaces found. Create one above!</p>
                @endforelse

                @if ($workspacesForView->hasPages())
                    <div class="mt-4">
                        {{ $workspacesForView->links() }}
                    </div>
                @endif
            </div>
        @else
            <x-loading-placeholder text="Fetching data..." minHeight="250px" spinnerSize="3rem" />
        @endif
    </div>
</div>