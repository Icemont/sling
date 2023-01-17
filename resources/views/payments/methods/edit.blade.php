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
            <h4 class="alert-title">{{ __('Payment method was not updated because there are errors in the form') }}
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
                    <h4 class="card-title">{{ __('Edit payment method #:id', ['id' => $paymentMethod->id]) }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment-methods.update', ['payment_method' => $paymentMethod->id]) }}"
                          method="post">
                        @csrf
                        @method('PUT')
                        <div class="row mb-2">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Payment Method Name') }}</label>
                                    <input type="text" name="name" value="{{ $paymentMethod->name }}"
                                           class="form-control"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="border rounded mb-3 p-4">
                            <label class="form-label required">{{ __('Attributes') }}</label>
                            <div id="attributes">
                                @if($paymentMethod->attributes && is_array($paymentMethod->attributes))
                                    @foreach($paymentMethod->attributes as $k => $v)
                                        <x-payment-method-attribute :key="$k" :value="$v" :removable="!$loop->first"/>
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
                                        <input name="is_active" value="1" class="form-check-input"
                                               type="checkbox"{{ $paymentMethod->is_active ? ' checked' : '' }}>
                                        <span class="form-check-label">{{ __('Active') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer text-end mt-0">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit"
                                     width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                    <line x1="16" y1="5" x2="19" y2="8"></line>
                                </svg>
                                {{ __('Update Payment Method') }}
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
