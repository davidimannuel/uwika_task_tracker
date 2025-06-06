<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}">
      <i class="bi bi-house"></i>
      Task Tracker
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @auth
        {{-- <x-nav-link :active="request()->routeIs('home')" href="{{ route('home') }}">Home</x-nav-link> --}}
        <x-nav-link :active="(request()->routeIs('workspaces.index'))" href="{{ route('workspaces.index') }}">Workspaces</x-nav-link>
          @if($firstWorkspace = Auth::user()->workspaces()->first())
          <x-nav-link :active="request()->routeIs('workspaces.tasks.board')" href="{{ route('workspaces.tasks.board', $firstWorkspace->workspace_id) }}">Board</x-nav-link>
          {{-- <x-nav-link :active="request()->routeIs('workspaces.tasks.*')" href="{{ route('workspaces.tasks.index', $firstWorkspace) }}">Tasks</x-nav-link> --}}
          @endif
        @endauth
      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          @auth
            <x-nav-link :active="request()->routeIs('profile')" href="{{ route('profile') }}">Profile</x-nav-link>
            <form action="{{ route('logout') }}" method="post" class="d-flex">
              @csrf
              <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
          @else
            <x-nav-link href="{{ route('login') }}">Login</x-nav-link>
            <x-nav-link href="{{ route('register') }}">Register</x-nav-link>
          @endauth
      </ul>
    </div>
  </div>
</nav>