@props(['name','type'])
@if (session($name))
  <div>
    <div class="alert alert-{{ $type }} d-flex align-items-center alert-dismissible fade show" role="alert">      
      @if ($type == 'warning' || $type == 'danger')
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
      @endif
      @if ($type == 'info')
        <i class="bi bi-exclamation-circle-fill me-2"></i>
      @endif
      @if ($type == 'success')
        <i class="bi bi-check-circle-fill me-2"></i>
      @endif
      {{ session($name) }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
@endif