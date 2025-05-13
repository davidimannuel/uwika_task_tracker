<div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Login</h5>
            <form wire:submit="login">
              <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" wire:model="form.email" placeholder="Enter your email">
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
              <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit">Login</button>
                <a href="{{ route('register') }}" class="text-decoration-none">Don't have an account? Register</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> 