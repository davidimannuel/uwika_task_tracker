{{-- filepath: resources/views/livewire/workspaces/row.blade.php --}}
<div class="card mb-2">
    <div class="card-body">
        <x-alert name="workspaceUpdated" type="success" />
        <x-alert name="workspaceError" type="danger" />
        @if ($isEditing)
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input
                    type="text"
                    class="form-control"
                    wire:model.defer="form.name"
                    wire:keydown.enter="saveEdit"
                    wire:keydown.escape="toggleEdit">
                @error('form.name') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea
                    class="form-control"
                    wire:model.defer="form.description"
                    rows="3"></textarea>
                @error('form.description') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
            </div>
            <div class="d-flex justify-content-end">
                <button wire:key="save-btn-{{ $workspace->id }}" class="btn btn-success btn-sm me-1" wire:click="saveEdit">Save</button>
                <button wire:key="cancel-btn-{{ $workspace->id }}" class="btn btn-secondary btn-sm" wire:click="toggleEdit">Cancel</button>
            </div>
        @else
            <div class="row">
                <div class="col">
                    <h5 class="mb-1">{{ $workspace->name }}</h5>
                    @if($workspace->description)
                        <p class="text-muted mb-1">{{ $workspace->description }}</p>
                    @endif
                    <div class="text-muted small">
                        Created by: {{ $workspace->creator->name }} ({{ $workspace->creator->email }})
                        @php
                            $member = $workspace->members->where('user_id', auth()->id())->first();
                        @endphp
                        @if($member)
                            <span class="ms-2">• Your role: {{ ucfirst($member->role) }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-auto d-flex align-items-start">
                    <a href="{{ route('workspaces.tasks.index', $workspace) }}" class="btn btn-info btn-sm me-1">Tasks</a>
                    <a href="{{ route('workspaces.members', $workspace) }}" class="btn btn-secondary btn-sm me-1">Members</a>
                    @if($member && in_array($member->role, ['owner', 'admin']))
                        <button wire:key="edit-btn-{{ $workspace->id }}" class="btn btn-primary btn-sm me-1" wire:click="toggleEdit">Edit</button>
                        <button
                            wire:key="delete-btn-{{ $workspace->id }}"
                            class="btn btn-danger btn-sm"
                            wire:click="deleteWorkspace"
                            wire:confirm="Are you sure you want to delete '{{ $workspace->name }}'? This action cannot be undone."
                        >Delete</button>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>