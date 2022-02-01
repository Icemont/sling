<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Payment methods') }}
            </h2>
            <div class="ms-auto">
                <a class="btn btn-primary" href="{{ route('payment-methods.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    {{ __('Add method') }}
                </a>
            </div>
        </div>
    </x-slot>
    @if (session('status'))
        <x-alert :type="session('type')" :message="session('status')" class="mb-2"/>
    @endif
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(count($payment_methods))
                        <div class="table-responsive">
                            <script type="text/javascript">
                                function deleteConfirm() {
                                    return confirm('{{ __('Are you sure you want to delete this payment method?') }}');
                                }
                            </script>
                            <table
                                class="table table-vcenter">
                                <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Created') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="w-1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payment_methods as $payment_method)
                                    <tr>
                                        <td>{{ $payment_method->id }}</td>
                                        <td>
                                            <a href="{{ route('payment-methods.show', ['payment_method' => $payment_method->id]) }}">{{ $payment_method->name }}</a>
                                        </td>
                                        <td class="text-muted">{{ $payment_method->created_at->format('d.m.Y') }}</td>
                                        <td class="small">
                                            @if($payment_method->is_active)
                                                <span class="badge bg-success">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('Disabled') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <a class="btn btn-outline-primary"
                                                   href="{{ route('payment-methods.edit', ['payment_method' => $payment_method->id]) }}">{{ __('Edit') }}</a>
                                                <form class="d-inline"
                                                      action="{{ route('payment-methods.destroy', ['payment_method' => $payment_method->id]) }}"
                                                      method="post" onsubmit="return deleteConfirm();">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-outline-danger">{{ __('Delete') }}</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($payment_methods->hasPages())
                                <div class="card-footer d-flex align-items-center">
                                    <p class="m-0 text-muted">{{ __('Showing :first to :last of :total entries',
['first' => $payment_methods->firstItem(), 'last' => $payment_methods->lastItem(), 'total' => $payment_methods->total()]) }}</p>
                                    <p class="pagination m-0 ms-auto">
                                        {{ $payment_methods->links() }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @else
                        {{ __('There are no payment methods in the database yet!') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
