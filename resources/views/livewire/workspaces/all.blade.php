<div>
    @foreach ($workspaces as $workspace)
        <livewire:workspaces.row 
            :rownumber="$loop->index + $workspaces->firstItem()" 
            :workspace="$workspace" 
            wire:key="{{ $workspace->id }}" />
    @endforeach
    <x-pagination :items="$workspaces" />
</div>
