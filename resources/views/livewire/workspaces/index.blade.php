<div>
    {{-- Create form component loads immediately --}}
    <livewire:workspaces.create />

    <hr>

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

    @script
    <script>
        $wire.on('show-alert', (event) => {
            alert(event.message);
        });
    </script>
    @endscript
</div>