<div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">New Workspace</h5>
            <form wire:submit="save">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" wire:model="form.name" placeholder="Enter workspace name">
                    @error('form.name') 
                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" wire:model="form.description" rows="3" placeholder="Enter workspace description"></textarea>
                    @error('form.description') 
                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>