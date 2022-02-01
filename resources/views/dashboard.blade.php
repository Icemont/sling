<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="row row-cards">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col-sm-6 col-lg-4">
                    <a class="card-link" href="{{ route('invoices.index') }}">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                            <span class="bg-blue text-white avatar">
                               <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-invoice"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path
                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                    <line x1="9" y1="7" x2="10" y2="7"></line>
                                    <line x1="9" y1="13" x2="15" y2="13"></line>
                                    <line x1="13" y1="17" x2="15" y2="17"></line>
                               </svg>
                            </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            {{ __(':number Invoices', ['number' => $statistic['invoices']['total']]) }}
                                        </div>
                                        <div class="text-muted">
                                            {{ __(':number waiting for payment', ['number' =>  $statistic['invoices']['non_paid']]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <a class="card-link" href="{{ route('reports.form') }}">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                            <span class="bg-green text-white avatar">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coin"
                                   width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                   fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="12" r="9"></circle>
                                <path
                                    d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"></path>
                                <path d="M12 6v2m0 8v2"></path>
                              </svg>
                            </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            {{ __(':amount :currency in sales', ['amount' => number_format($statistic['sales']['total']), 'currency' => $statistic['currency_code']]) }}
                                        </div>
                                        <div class="text-muted">
                                            {{ __(':amount :currency this month', ['amount' => number_format($statistic['sales']['month']), 'currency' =>  $statistic['currency_code']]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <a class="card-link" href="{{ route('clients.index') }}">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                            <span class="bg-azure text-white avatar">
                               <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                              </svg>
                            </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            {{ $statistic['clients'] }}
                                        </div>
                                        <div class="text-muted">
                                            {{ __('Clients') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
