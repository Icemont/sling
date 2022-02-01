@props(['key', 'value', 'removable', 'readonly' => false])

<div {{ $attributes->merge(['class' => 'row mb-4 mb-md-0']) }}>
    <div class="col-md-5">
        <div class="mb-3">
            <input type="text" name="method_attributes[keys][]" value="{{ $key }}" class="form-control"
                   placeholder="{{ __('Attribute Name') }}" {{ $readonly ? 'readonly' : 'required' }}>
        </div>
    </div>
    <div class="col-md-5">
        <div class="mb-3">
            <input type="text" name="method_attributes[values][]" value="{{ $value }}"
                   placeholder="{{ __('Value') }}" class="form-control" {{ $readonly ? 'readonly' : 'required' }}>
        </div>
    </div>
    @if($removable)
    <div class="col-md-2">
        <div class="mb-3">
            <a href="#" class="attributes-remove btn btn-warning">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="icon icon-tabler icon-tabler-trash" width="24" height="24"
                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="4" y1="7" x2="20" y2="7"></line>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                </svg>
                {{ __('Remove') }}
            </a>
        </div>
    </div>
    @endif
</div>
