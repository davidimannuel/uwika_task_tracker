<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profile</h5>
                        <form wire:submit="updateProfile">
                            <div class="mb-4">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" wire:model="form.name" placeholder="Enter your name">
                                @error('form.name') 
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ auth()->user()->email }}" disabled>
                                <small class="text-muted">Email cannot be changed</small>
                            </div>
                            <button class="btn btn-primary" type="submit">Update Profile</button>
                        </form>

                        <hr class="my-4">

                        <h5 class="card-title">Change Password</h5>
                        <form wire:submit="updatePassword">
                            <div class="mb-4">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" wire:model="form.current_password" placeholder="Enter your current password">
                                @error('form.current_password') 
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" wire:model="form.new_password" placeholder="Enter your new password">
                                @error('form.new_password') 
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="new_password_confirmation" wire:model="form.new_password_confirmation" placeholder="Confirm your new password">
                            </div>
                            <button class="btn btn-primary" type="submit">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('alert', (event) => {
                alert(event.message);
            });
        });
    </script>
</div> 