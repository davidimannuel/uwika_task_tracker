{{-- filepath: resources/views/livewire/workspaces/row.blade.php --}}
<div class="card mb-2">
    <div class="card-body d-flex justify-content-between align-items-center">
        @if ($isEditing)
            <div class="flex-grow-1 me-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    wire:model.defer="form.name"
                    wire:keydown.enter="saveEdit"
                    wire:keydown.escape="toggleEdit">
                @error('form.name') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
            </div>
            <div>
                <button wire:key="save-btn-{{ $workspace->id }}" class="btn btn-success btn-sm me-1" wire:click="saveEdit">Save</button>
                <button wire:key="cancel-btn-{{ $workspace->id }}" class="btn btn-secondary btn-sm" wire:click="toggleEdit">Cancel</button>
            </div>
        @else
            <div class="flex-grow-1">
                {{ $rownumber }}. {{ $workspace->name }}
                @if($workspace->user)
                    <small class="text-muted d-block">Owner: {{ $workspace->user->name }}</small>
                @endif
            </div>
            <div>
                <button wire:key="edit-btn-{{ $workspace->id }}" class="btn btn-primary btn-sm me-1" wire:click="toggleEdit">Edit</button>
                <button
                    wire:key="delete-btn-{{ $workspace->id }}"
                    class="btn btn-danger btn-sm"
                    wire:click="deleteWorkspace"
                    wire:confirm="Are you sure you want to delete '{{ $workspace->name }}'? This action cannot be undone."
                >Delete</button>
            </div>
        @endif
    </div>
</div>