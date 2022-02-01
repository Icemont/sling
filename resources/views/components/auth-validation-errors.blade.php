@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'alert alert-warning', 'role' => 'alert']) }}>
        <h4 class="alert-title">{{ __('Whoops! Something went wrong.') }}</h4>
        @foreach ($errors->all() as $error)
            <div class="text-muted">{{ $error }}</div>
        @endforeach
    </div>
@endif
