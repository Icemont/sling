<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <ol class="page-title breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="{{ route('payment-methods.index') }}">{{ __('Payment methods') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Edit #:id', ['id' => $paymentMethod->id]) }}</li>
            </ol>
        </div>
    </x-slot>
    <x-errors :errors="$errors" title="{{ __('Payment method was not updated because there are errors in the form') }}" />
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
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
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirm">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 7h16" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    <path d="M10 12l4 4m0 -4l-4 4" />
                                </svg>
                                {{ __('Delete') }}
                            </button>
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
    <div class="modal fade" id="deleteConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <i class="fa-solid fa-triangle-exclamation text-danger mb-2" style="font-size:xxx-large"></i>
                    <h3>{{ __('Delete confirmation') }}</h3>
                    <div class="text-muted">{{ __('Are you sure you want to delete this payment method?') }}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-ban"></i>&nbsp;{{ __('Cancel') }}
                    </button>
                    <form class="ms-auto" method="post"
                          action="{{ route('payment-methods.destroy', ['payment_method' => $paymentMethod->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash-can"></i>&nbsp;{{ __('Delete') }}
                        </button>
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
