<div>
    <x-alert name="success-create" type="success" />
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">New Task</h5>
            <form wire:submit="save">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" wire:model="form.title" placeholder="Enter task title">
                    @error('form.title') 
                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" wire:model="form.description" rows="3" placeholder="Enter task description"></textarea>
                    @error('form.description') 
                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">Assign To</label>
                            <select class="form-select" id="assigned_to" wire:model="form.assigned_to">
                                <option value="">Unassigned</option>
                                @foreach($workspace->members as $member)
                                    <option value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                                @endforeach
                            </select>
                            @error('form.assigned_to') 
                                <small class="d-block mt-1 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="scheduled_at" class="form-label">Scheduled Date</label>
                            <input type="date" class="form-control" id="scheduled_at" wire:model="form.scheduled_at">
                            @error('form.scheduled_at') 
                                <small class="d-block mt-1 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="due_at" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_at" wire:model="form.due_at">
                            @error('form.due_at') 
                                <small class="d-block mt-1 text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div> 