@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success', 'role' => 'alert']) }}>
        <div class="text-muted">{{ $status }}</div>
    </div>
@endif
