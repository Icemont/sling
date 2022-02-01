<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Sales report') }}
            </h2>
            <div class="ms-auto">
                <a class="btn btn-primary" href="{{ route('reports.form') }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="icon icon-tabler icon-tabler-report" width="24" height="24"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697"></path>
                        <path d="M18 14v4h4"></path>
                        <path d="M18 11v-4a2 2 0 0 0 -2 -2h-2"></path>
                        <rect x="8" y="3" width="6" height="4" rx="2"></rect>
                        <circle cx="18" cy="18" r="4"></circle>
                        <path d="M8 11h4"></path>
                        <path d="M8 15h3"></path>
                    </svg>
                    {{ __('Create report') }}
                </a>
            </div>
        </div>
    </x-slot>
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Sales report :from — :to',[
    'from' =>  $params['from_date']->format('d.m.Y'),
    'to' => $params['to_date']->format('d.m.Y')
    ]) }}</h4>

                </div>
                <div class="card-body">
                    @if(count($report))
                        <div class="table-responsive" style="min-height:20em;">
                            @foreach($report as $invoices)
                                <table class="table table-vcenter table-borderless mb-3">
                                    @foreach($invoices as $invoice)
                                        @if($loop->first)
                                            <tr class="bg-blue-lt">
                                                <th colspan="2">{{ $invoice->client_name }}</th>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>{{ $invoice->payment_date->format('d.m.Y') }}
                                                ({{ $invoice->invoice_number }})
                                            </td>
                                            <td>
                                                <div class="float-end">
                                                    {{ $invoice->amount }} {{ $user->currency->code }}
                                                </div>
                                            </td>
                                        </tr>
                                        @if($loop->last)
                                            <tr class="border-top">
                                                <td colspan="2">
                                                    <div class="float-end">
                                                        <strong>{{ $invoices->sum('amount') }} {{ $user->currency->code }}</strong>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                                @if($loop->last)
                                    <table class="table table-vcenter table-borderless mb-4">
                                        <tr class="bg-primary text-light">
                                            <th>{{ __('Total') }}</th>
                                            <td>
                                                <div class="float-end">
                                                    <strong>{{ number_format($total, 2) }} {{ $user->currency->code }}</strong>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                @endif
                            @endforeach
                            <div class="small text-danger text-end">* {{ __('Subtotals are displayed to 6 decimal places') }}</div>
                        </div>
                    @else
                        {{ __('There is no data for the selected period.') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
