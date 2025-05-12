<div>
    <x-alert name="success-update" type="success" />
    <form wire:submit="save">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('form.title') is-invalid @enderror" id="title" wire:model="form.title" @if(!$isAuthorized) disabled readonly @endif>
            @error('form.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('form.description') is-invalid @enderror" id="description" wire:model="form.description" rows="3" @if(!$isAuthorized) disabled readonly @endif></textarea>
            @error('form.description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="scheduled_at" class="form-label">Scheduled Date</label>
            <input type="date" class="form-control @error('form.scheduled_at') is-invalid @enderror" id="scheduled_at" wire:model="form.scheduled_at" @if(!$isAuthorized) disabled readonly @endif>
            @error('form.scheduled_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="due_at" class="form-label">Due Date</label>
            <input type="date" class="form-control @error('form.due_at') is-invalid @enderror" id="due_at" wire:model="form.due_at" @if(!$isAuthorized) disabled readonly @endif>
            @error('form.due_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="assigned_to" class="form-label">Assign To</label>
            <select class="form-select @error('form.assigned_to') is-invalid @enderror" id="assigned_to" wire:model="form.assigned_to" @if(!$isAuthorized) disabled @endif>
                <option value="">Unassigned</option>
                @foreach($task->workspace->members as $member)
                    <option value="{{ $member->user_id }}">{{ $member->user->name }}</option>
                @endforeach
            </select>
            @error('form.assigned_to') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" wire:click="$dispatch('close-edit-form')">Cancel</button>
            @if($isAuthorized)
                <button type="submit" class="btn btn-primary">Save Changes</button>
            @endif
        </div>
    </form>
</div> 