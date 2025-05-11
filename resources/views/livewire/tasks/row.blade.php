{{-- filepath: resources/views/livewire/tasks/row.blade.php --}}
<div class="card mb-2">
    <div class="card-body">
        <x-alert name="success-update" type="success" />
        <x-alert name="success-delete" type="success" />
        <x-alert name="error" type="danger" />
        @if ($isEditing)
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input
                    type="text"
                    class="form-control"
                    wire:model.defer="form.title"
                    wire:keydown.enter="saveEdit"
                    wire:keydown.escape="toggleEdit">
                @error('form.title') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea
                    class="form-control"
                    wire:model.defer="form.description"
                    rows="3"></textarea>
                @error('form.description') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" wire:model.defer="form.status">
                            <option value="todo">To Do</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                        @error('form.status') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Assign To</label>
                        <select class="form-select" wire:model.defer="form.assigned_to">
                            <option value="">Unassigned</option>
                            @foreach($task->workspace->members as $member)
                                <option value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                            @endforeach
                        </select>
                        @error('form.assigned_to') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Scheduled Date</label>
                        <input type="date" class="form-control" wire:model.defer="form.scheduled_at">
                        @error('form.scheduled_at') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" class="form-control" wire:model.defer="form.due_at">
                        @error('form.due_at') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button wire:key="save-btn-{{ $task->id }}" class="btn btn-success btn-sm me-1" wire:click="saveEdit">Save</button>
                <button wire:key="cancel-btn-{{ $task->id }}" class="btn btn-secondary btn-sm" wire:click="toggleEdit">Cancel</button>
            </div>
        @else
            <div class="row">
                <div class="col">
                    <h5 class="mb-1">{{ $task->title }}</h5>
                    @if($task->description)
                        <p class="text-muted mb-1">{{ $task->description }}</p>
                    @endif
                    <div class="text-muted small">
                        <span class="badge bg-{{ $task->status === 'todo' ? 'secondary' : ($task->status === 'in_progress' ? 'primary' : 'success') }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                        @if($task->scheduled_at)
                            <span class="ms-2">• Scheduled: {{ $task->scheduled_at->format('M d, Y') }}</span>
                        @endif
                        @if($task->due_at)
                            <span class="ms-2">• Due: {{ $task->due_at->format('M d, Y') }}</span>
                        @endif
                        @if($task->assignee)
                            <span class="ms-2">• Assigned to: {{ $task->assignee->name }}</span>
                        @endif
                        <span class="ms-2">• Created by: {{ $task->creator->name }}</span>
                    </div>
                </div>
                @php
                    $member = $task->workspace->members->where('user_id', auth()->id())->first();
                @endphp
                @if($member && in_array($member->role, ['owner', 'admin']))
                    <div class="col-auto d-flex align-items-start">
                        <button wire:key="edit-btn-{{ $task->id }}" class="btn btn-primary btn-sm me-1" wire:click="toggleEdit">Edit</button>
                        <button
                            wire:key="delete-btn-{{ $task->id }}"
                            class="btn btn-danger btn-sm"
                            wire:click="deleteTask"
                            wire:confirm="Are you sure you want to delete '{{ $task->title }}'? This action cannot be undone."
                        >Delete</button>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div> 