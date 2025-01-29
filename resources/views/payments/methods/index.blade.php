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
                    @if(count($payment_methods))
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter">
                                <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payment_methods as $payment_method)
                                    <tr>
                                        <td class="w-1">{{ $payment_method->id }}</td>
                                        <td class="w-100">
                                            <a href="{{ route('payment-methods.show', ['payment_method' => $payment_method->id]) }}">{{ $payment_method->name }}</a>
                                        </td>
                                        <td class="text-nowrap">
                                            @if($payment_method->is_active)
                                                <span class="badge bg-green-lt">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge bg-danger-lt">{{ __('Disabled') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap text-muted">{{ $payment_method->created_at->format('d.m.Y H:i') }}</td>
                                        <td class="text-nowrap text-end">
                                            <a href="{{ route('payment-methods.edit', ['payment_method' => $payment_method->id]) }}">
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
                                <p class="m-0 text-muted">{{ __('Showing :first to :last of :total entries',
['first' => $payment_methods->firstItem(), 'last' => $payment_methods->lastItem(), 'total' => $payment_methods->total()]) }}</p>
                                @if($payment_methods->hasPages())
                                    <p class="pagination m-0 ms-auto">
                                        {{ $payment_methods->links() }}
                                    </p>

                                @endif
                            </div>
                        </div>
                    @else
                        {{ __('There are no payment methods in the database yet!') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
