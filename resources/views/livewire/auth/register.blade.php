<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Register</h5>
                        <form wire:submit="register">
                            <div class="mb-4">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" wire:model="form.name" placeholder="Enter your name">
                                @error('form.name') 
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" wire:model="form.email" placeholder="Enter your email">
                                @error('form.email') 
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" wire:model="form.password" placeholder="Enter your password">
                                @error('form.password') 
                                    <small class="d-block mt-1 text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" wire:model="form.password_confirmation" placeholder="Confirm your password">
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-primary" type="submit">Register</button>
                                <a href="{{ route('login') }}" class="text-decoration-none">Already have an account? Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 