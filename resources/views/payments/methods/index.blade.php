<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <ol class="page-title breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                <li class="breadcrumb-item active" aria-current="page">{{ __('Payment methods') }}</li>
            </ol>
            <div class="ms-auto">
                <a href="{{ route('payment-methods.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    {{ __('Add method') }}
                </a>
            </div>
        </div>
    </x-slot>
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(count($paymentMethods))
                        <div class="table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created') }}</th>
                                    <th class="w-1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($paymentMethods as $paymentMethod)
                                    <tr>
                                        <td class="w-1">{{ $paymentMethod->id }}</td>
                                        <td class="w-100">
                                            <a href="{{ route('payment-methods.show', ['payment_method' => $paymentMethod->id]) }}">{{ $paymentMethod->name }}</a>
                                        </td>
                                        <td class="text-nowrap">
                                            @if($paymentMethod->is_active)
                                                <span class="badge bg-green-lt">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge bg-red-lt">{{ __('Disabled') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap text-secondary">{{ $paymentMethod->created_at->format('d.m.Y H:i') }}</td>
                                        <td class="text-nowrap text-end">
                                            <a href="{{ route('payment-methods.edit', ['payment_method' => $paymentMethod->id]) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="icon">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                                    <path d="M16 5l3 3"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="card-footer d-flex align-items-center">
                                <p class="m-0 text-muted">{{ __('Showing :first to :last of :total entries', [
                                        'first' => $paymentMethods->firstItem(),
                                        'last' => $paymentMethods->lastItem(),
                                        'total' => $paymentMethods->total(),
                                    ]) }}</p>
                                @if($paymentMethods->hasPages())
                                    <p class="pagination m-0 ms-auto">{{ $paymentMethods->links() }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="empty">
                            <div class="empty-img">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="icon icon-lg text-primary">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"/>
                                    <path d="M3 10l18 0"/>
                                    <path d="M7 15l.01 0"/>
                                    <path d="M11 15l2 0"/>
                                </svg>
                            </div>
                            <p class="empty-title">{{ __('Payment methods are managed from here') }}</p>
                            <p class="empty-subtitle text-secondary">
                                {{ __('There are no payment methods in the database yet') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
