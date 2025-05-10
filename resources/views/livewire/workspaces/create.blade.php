<div>
    <x-alert name="success-create" type="success" />
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">New Workspace</h5>
            <form wire:submit="save">
                <div class="mb-2">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" wire:model="form.name" placeholder="Enter your name">
                    @error('form.name') 
                        <small class="d-block mt-1 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>