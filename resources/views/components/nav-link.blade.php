@props(['active'])

@php
$link_class = ($active ?? false)
            ? 'nav-item active'
            : 'nav-item';
@endphp

<li class="{{ $link_class }}">
    <a {{ $attributes->merge(['class' => 'nav-link']) }}>
        @isset($icon)
            <span class="nav-link-icon d-md-none d-lg-inline-block">{{ $icon }}</span>
        @endisset
        <span class="nav-link-title">{{ $slot }}</span>
    </a>
</li>
