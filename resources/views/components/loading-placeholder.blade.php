@props([
    'text' => 'Loading...',
    'minHeight' => '150px', // Default minimum height to prevent collapsing
    'spinnerClass' => 'spinner-border text-primary',
    'spinnerSize' => '2rem', // e.g., '2rem', '3rem'
    'textSize' => 'fs-6', // e.g., 'fs-5', 'fs-6', 'text-muted'
])

<div {{ $attributes->merge(['class' => 'd-flex flex-column justify-content-center align-items-center w-100']) }} style="min-height: {{ $minHeight }};">
    <div class="{{ $spinnerClass }}" role="status" style="width: {{ $spinnerSize }}; height: {{ $spinnerSize }};">
        <span class="visually-hidden">{{ $text }}</span>
    </div>
    @if($text)
        <p class="ms-2 mb-0 mt-2 {{ $textSize }}">{{ $text }}</p>
    @endif
</div>