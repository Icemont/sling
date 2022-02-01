<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Payment methods') }}
            </h2>
        </div>
    </x-slot>
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4 class="alert-title">{{ __('New payment method was not added because there are errors in the form') }}
                :</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Add payment method') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment-methods.store') }}" method="post">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Payment Method Name') }}</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="border rounded mb-3 p-4">
                            <label class="form-label required">{{ __('Attributes') }}</label>
                            <div id="attributes">
                                @if(old('method_attributes.keys') !== null)
                                    @foreach(old('method_attributes.keys', []) as $k => $v)
                                        <x-payment-method-attribute :key="$v"
                                                                    value="{{ old('method_attributes.values.' . $k) }}"
                                                                    :removable="!$loop->first"/>
                                    @endforeach
                                @else
                                    <x-payment-method-attribute key="" value="" :removable="false"/>
                                @endif
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-10"></div>
                                <div class="col-auto">
                                    @include('payments.methods.partials.attributes-add-button')
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-check form-switch">
                                        <input name="is_active" value="1" class="form-check-input" type="checkbox"
                                               checked>
                                        <span class="form-check-label">{{ __('Active') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer text-end mt-0">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                     width="24"
                                     height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                {{ __('Add Payment Method') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <template class="attributes-tpl">
        <x-payment-method-attribute key="" value="" :removable="true"/>
    </template>
    @include('payments.methods.partials.attributes-js')
</x-app-layout>
